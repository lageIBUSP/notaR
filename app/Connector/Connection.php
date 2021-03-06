<?php

namespace App\Connector;
use Sentiweb\Rserve\Connection as BaseConnection;

use Sentiweb\Rserve\Parser;
use Sentiweb\Rserve\Parser\NativeArray;

class Connection extends BaseConnection {

	/**
	 * Open a new socket to Rserv
	 * @return resource socket
	 */
	private function openSocket($session_key = null) {

		if( $this->port == 0 ) {
			$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
		} else {
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		}
		if( !$socket ) {
			throw new Exception('Unable to create socket ['.socket_strerror(socket_last_error()).']');
		}
		//socket_set_option($socket, SOL_TCP, SO_DEBUG,2);

		$ok = socket_connect($socket, $this->host, $this->port);
		if( !$ok ) {
			throw new Exception('Unable to connect ['.socket_strerror(socket_last_error()).']');
		}
		$this->socket = $socket;
		if( !is_null($session_key) ) {
			// Try to resume session
			$n = socket_send($socket, $session_key, 32, 0);
			if($n < 32) {
				throw new Exception('Unable to send session key');
			}
			$r = $this->getResponse();
			if($r && $r['is_error']) {
				$msg = $this->getErrorMessage($r['error']);
				throw new Exception('invalid session key : '.$msg);
			}
			return;
		}

		// No session, check handshake
		$buf = '';
		$n = socket_recv($socket, $buf, 32, 0);
		if( $n < 32 || strncmp($buf, 'Rsrv', 4) != 0 ) {
			throw new Exception('Invalid response from server.');
		}
		$rv = substr($buf, 4, 4);
		if( strcmp($rv, '0103') != 0 ) {
			throw new Exception('Unsupported protocol version.');
		}
		$key=null;
		$this->auth_request = false;
		for($i = 12; $i < 32; $i += 4) {
			$attr = substr($buf, $i, 4);
			if($attr == 'ARpt') {
				$this->auth_request = true;
				$this->auth_method = 'plain';

			} elseif($attr == 'ARuc') {
				$this->auth_request = true;
				$this->auth_method = 'crypt';
			}
			if($attr[0] === 'K') {
				$key = substr($attr, 1, 3);
			}
		}
		if($this->auth_request === true) {
			if($this->auth_method=="plain") $this->login(); else $this->login($key);
		}
		
		if($this->encoding) {
			$this->setEncoding($this->encoding);
		}
	}

	/**
	 * Login to rserve
	 * Similar to RSlogin  http://rforge.net/doc/packages/RSclient/Rclient.html
	 * Inspired from https://github.com/SurajGupta/RserveCLI2/blob/master/RServeCLI2/Qap1.cs
	 *               https://github.com/SurajGupta/RserveCLI2/blob/master/RServeCLI2/RConnection.cs
	 * @param string $salt
	 */
	public function login($salt=null) {
		switch ( $this->auth_method )
		{
		case "plain":
			break;
		case "crypt":
			if( !$salt ) {
				throw new Exception("Should pass the salt for login");
			}
			$this->password=crypt($this->password, $salt);
			break;
		default:
			throw new Exception( "Could not interpret login method '{$this->auth_method}'" );
		}
		$data = _rserve_make_data(self::DT_STRING, "{$this->username}\n{$this->password}");
		$r = $this->sendCommand(self::CMD_login, $data );
		if( $r && !$r['is_error'] ) {
			return true;
		}
		throw new Exception( "Could not login" );
	}

	/**
	 * Evaluate a string as an R code and return result
	 * @param string $string
	 * @param int $parser
	 */
	public function evalString($string, $parser = null) {

		$data = _rserve_make_data(self::DT_STRING, $string);

		$r = $this->sendCommand(self::CMD_eval, $data );
		if($this->async) {
			return true;
		}
		if( $r && !$r['is_error'] ) {
				return $this->parseResponse($r['contents'], $parser);
		}
		if( $r === false) {
			return null;
		}
		$msg = $this->getErrorMessage($r['error']);
		throw new Exception('unable to evaluate: '.$msg, $r);
	}


	/**
	 * Detach the current session from the current connection.
	 * Save envirnoment could be attached to another R connection later
	 * @return array with session_key used to
	 * @throws Exception
	 */
	public function detachSession() {
		$r = $this->sendCommand(self::CMD_detachSession, null);
		if($r && !$r['is_error'] ) {
			$x = $r['contents'];
			if( strlen($x) != (32 + 3 * 4) ) {
				throw new Exception('Invalid response to detach');
			}

			$port  =  _rserve_int32($x, 4);
			$key = substr($x, 12);
			$session = new Session($key, $this->host, $port);

			return $session;
		}
		throw new Exception('Unable to detach sesssion', $r);
	}
	/**
	 * Get the response from a command
	 * @param resource	$socket
	 * @return array contents
	 */
	protected function getResponse() {
		$header = null;
		$n = socket_recv($this->socket, $header, 16, 0);
		if ($n === false) {
			$err = socket_last_error();
			throw new Exception ('Error '.$err.': '.socket_strerror($err));
		}
		if ($n != 16) {
			// header should be sent in one block of 16 bytes
			return false;
		}
		$len = _rserve_int32($header, 4);
		$ltg = $len; // length to get
		$buf = '';
		while ($ltg > 0) {
			$n = socket_recv($this->socket, $b2, $ltg, 0);
			if ($n > 0) {
				$buf .= $b2;
				unset($b2);
				$ltg -= $n;
			} else {
			 break;
			}
		}
		$res = _rserve_int32($header);
		return(array(
			'code'=>$res,
			'is_error'=>($res & 15) != 1,
			'error'=>($res >> 24) & 127,
			'header'=>$header,
			'contents'=>$buf // Buffer contains messages part
		));
	}

	/**
	 * Get results from an eval command  in async mode
	 * @param Parser $parser, if null use internal parser
	 * @return mixed contents of response
	 */
	public function getResults($parser = null) {
		$r = $this->getResponse();
		if( $r && !$r['is_error'] ) {
			return $this->parseResponse($r['contents'], $parser);
		}
		throw new Exception('unable to evaluate', $r);
	}
	/**
	 * Translate an error code to an error message
	 * @param int $code
	 */
	public function getErrorMessage($code) {
		switch($code) {
			case self::ERR_auth_failed	: $m = 'auth failed'; break;
			case self::ERR_conn_broken	: $m = 'connexion broken'; break;
			case self::ERR_inv_cmd		:  $m = 'invalid command'; break;
			case self::ERR_inv_par		:  $m = 'invalid parameter'; break;
			case self::ERR_Rerror		:  $m = 'R error'; break;
			case self::ERR_IOerror		:  $m = 'IO error'; break;
			case self::ERR_not_open		:  $m = 'not open'; break;
			case self::ERR_access_denied :  $m = 'access denied'; break;
			case self::ERR_unsupported_cmd: $m = 'unsupported command'; break;
			case self::ERR_unknown_cmd	:  $m = 'unknown command'; break;
			case self::ERR_data_overflow	:  $m = 'data overflow'; break;
			case self::ERR_object_too_big :  $m = 'object too big'; break;
			case self::ERR_out_of_mem	:  $m = 'out of memory' ; break;
			case self::ERR_ctrl_closed	:  $m = 'control closed'; break;
			case self::ERR_session_busy	: $m = 'session busy'; break;
			case self::ERR_detach_failed	:  $m = 'detach failed'; break;
			default:
				$m = 'internal R error';
		}
		return $m;
	}

}






