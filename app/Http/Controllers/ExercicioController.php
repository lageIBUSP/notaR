<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Exercicio;
use App\Models\Teste;
use App\Models\Topico;
use App\Models\Impedimento;
use App\Utils\TmpFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use \ForceUTF8\Encoding;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Symfony\Component\Yaml\Yaml;
use \Sentiweb\Rserve\Connection;
use \Sentiweb\Rserve\Exception as RserveException;
use Exception;

class ExercicioController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 */
	public function index()
	{
    $topicos = Topico::orderBy('order');
    $semTopico = Exercicio::whereDoesntHave('topico');
    /** @var \App\Models\User */
    $user = Auth::user();
    if (optional($user)->isAdmin()) {
      $topicos = $topicos->with('exercicios');
    } else {
      $topicos = $topicos->with('exerciciosPublished');
      $semTopico = $semTopico->published();
    }

    return View('exercicio.index')->with('topicos', $topicos->get())
      ->with('semTopico', $semTopico->get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->authorize('create', Exercicio::class);
		return View('exercicio.create')
			->with('pacotesR', $this->getInstalledPackages())
			->with('topicos', Topico::all());
	}

	/**
	 * Validate model
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return mixed
	 */
	private function validateRequest(Request $request, Exercicio|null $exercicio = null)
	{
		$rules = array(
			'name' => 'required|string|unique:exercicios' . ($exercicio ? ',name,' . $exercicio->id : ''),
			'description' => 'required',
			'precondicoes' => 'sometimes',
			'topico_id' => 'sometimes|int|exists:topicos,id|nullable',
			'dicas' => 'array',
			'condicoes' => 'array',
			'pesos' => 'array',
			'dicas.*' => 'required',
			'condicoes.*' => 'required',
			'pesos.*' => 'required|numeric|min:0',
			'draft' => 'required|boolean',
		);
		$data = $request->validate($rules);

		// corrigir EOL
		$data['precondicoes'] = str_replace("\r\n", "\n", $data['precondicoes']);
		$data['description'] = str_replace("\r\n", "\n", $data['description']);

		return $data;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{
		$this->authorize('create', Exercicio::class);

		$data = $this->validateRequest($request);
		// store
		$exercicio = new Exercicio($data);
		DB::transaction(function () use ($data, $exercicio) {
			$exercicio->save();

			$n = count($data['dicas']);
			for ($i = 0; $i < $n; $i++) {
				Teste::create([
					'condicao' => $data['condicoes'][$i],
					'dica' => $data['dicas'][$i],
					'peso' => $data['pesos'][$i],
					'exercicio_id' => $exercicio->id
				]);
			}
		});

		$test = $this->corretoR($exercicio, "/usr/local/src/notar/runtest.R");
		if ($test['status'] == 'danger') {
			return redirect()->action(
				[ExercicioController::class, 'edit'],
				['exercicio' => $exercicio]
			)->withErrors(
				['precondicoes' => 'Ocorreu um erro ao testar as precondições.']
			);
		}

		return redirect()->action([ExercicioController::class, 'show'], ['exercicio' => $exercicio]);
	}

	/**
	 * Show the profile of a given Exercicio.
	 *
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function show(Exercicio $exercicio)
	{
		$this->authorize('view', $exercicio);
		$prazo = Auth::user() ? Auth::user()->prazo($exercicio) : false;

		return View('exercicio.show')->with('exercicio', $exercicio)
			->with('foraDoPrazo', $prazo ? $prazo->prazo <= now() : false);
	}

	/**
	 * Retorna uma lista de pacotes instalados no ambiente R
	 *
	 * @return array | null
	 */
	private function getInstalledPackages()
	{
		try {
			$cnx = new Connection('r');

			$rcode = 'pkgs <- installed.packages();'
				. 'pkgs[,1];'
			;
			// resposta do R
			$r = $cnx->evalString($rcode);

			return ($r);
		} catch (Exception $e) {
			Log::error('Erro de conexão em getInstalledPackages');
			return null;
		}
	}

	/**
	 * Roda o corretoR usando o código
	 *
	 * @param  Exercicio $exercicio
	 * @param  string $codigo
	 * @return array
	 */
	private function corretoR(Exercicio $exercicio, string $file)
	{
		// resposta do R
		try {
			$cnx = new Connection('r');
		} catch (Exception $e) {
			Log::error('Erro ao conectar ao serviço R');
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro ao conectar com o serviço R. Por favor contate um administrador.',
				'resultado' => null,
				'nota' => 0
			];
		}

		try {
			$rcode = ''
				// database auth
				. 'dbusr  <- "' . env('DB_USERNAME') . '";'
				. 'dbpass <- "' . env('DB_PASSWORD') . '";'
				. 'dbname <- "' . env('DB_DATABASE') . '";'
				. 'con <- connect(dbusr, dbpass, dbname);'
				. 'TRUE;' // This is to prevent connection object being returned (which causes an echo warning visible in production)
				;
			$r = $cnx->evalString($rcode);
		} catch (Exception $e) {
			Log::error('Erro ao na conexão RMySql');
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro ao acessar os testes do exercício. Por favor contate um administrador.',
				'resultado' => null,
				'nota' => 0
			];
		}

		try {
			// run corretoR
			$rcode = 'notaR(' . $exercicio->id . ',"' . $file . '");';
			$r = $cnx->evalString($rcode);
		} catch (Exception $e) {
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro na correção do exercício! Por favor verifique seu código ou contate um administrador.',
				'resultado' => null,
				'nota' => 0
			];
		}

		// syntax error
		if ($r === null) {
			return [
				'status' => 'danger',
				'mensagem' => 'Ocorreu um erro na execução do seu código! Corrija e tente novamente.',
				'resultado' => $r,
				'nota' => 0
			];
		}

		// garantee that $r is an array ffs
		if (is_bool($r)) {
			$r = [$r];
		}

		// 100%
		if (in_array(false, $r, true) === false) {
			return [
				'status' => 'success',
				'mensagem' => 'Parabéns! Seu código passou em todos os testes! <br>'
					. 'Toca aqui!',
				'resultado' => $r,
				'nota' => 100
			];
		}

		// pega lista de testes
		$testes = $exercicio->testes;
		// calcula nota
		$nota = 0;
		$firstmistake = -1;
		for ($i = 0; $i < count($testes); $i++) {
			if ($r[$i]) {
				$nota += $testes[$i]->peso;
			} else if ($firstmistake == -1) {
				$firstmistake = $i;
			}
		}
		$dica = $testes[$firstmistake]->dica;
		$notamax = $testes->sum('peso');
		$notanormalizada = 100 * $nota / $notamax;

		return [
			'status' => 'warning',
			'mensagem' => $dica,
			'resultado' => $r,
			'nota' => $notanormalizada
		];

	}

	/**
	 * Ação de fazer exercício usando o form
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function submit(Request $request, Exercicio $exercicio)
	{
		$rules = array(
			'codigo' => 'required'
		);
		$data = $request->validate($rules);

		$validator = Validator::make($request->all(), $rules);
		return $this->recebeCodigo($data['codigo'], $exercicio, $validator);
	}

	/**
	 * Ação de fazer exercício usando file upload
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\View\View
	 */
	public function upload(Request $request, Exercicio $exercicio)
	{
		$rules = array(
			'file' => 'required|mimetypes:text/plain'
		);
		$request->validate($rules);

		$validator = Validator::make($request->all(), $rules);

		$codigo = $request->file('file')->get();
		// convert to </utf-8>
		$codigo = Encoding::toUTF8($codigo);
		return $this->recebeCodigo($codigo, $exercicio, $validator);
	}

	private function recebeCodigo(string $codigo, Exercicio $exercicio, \Illuminate\Contracts\Validation\Validator $validator)
	{

		$user = Auth::user();
		if ($user) {
			Log::info('User ' . $user->id . ' submitted an answer to exercise ' . $exercicio->id);
		} else {
			Log::info('Guest submitted an answer to exercise ' . $exercicio->id);
		}

		$validator->after(function ($validator) use ($codigo) {
			foreach (Impedimento::all()->pluck('palavra') as $palavra) {
				if (Str::contains($codigo, $palavra)) {
					$validator->errors()->add(
						'codigo',
						'Código não pode conter a palavra: ' . $palavra
					);
				}
			}
		});
		if ($validator->fails()) {
			return redirect(URL::to('exercicio/' . $exercicio->id))
				->withErrors($validator)
				->withInput();
		}

		// corrigir EOL
		$codigo = str_replace("\r\n", PHP_EOL, $codigo).PHP_EOL;

		// salva um arquivo com o codigo
		$tempfile = TmpFile::generateTmpFileName(md5($codigo), '.R');
		Storage::put($tempfile, $codigo);
		// corrige
		$respostaR = $this->corretoR($exercicio, $tempfile);
		// deleta arquivo temporário
		Storage::delete($tempfile);

		// salvar nota no banco de dados
		if ($user && !$exercicio->draft) {
			$exercicio->notas()->create([
				'nota' => $respostaR['nota'],
				'user_id' => $user->id,
				'testes' => $respostaR['resultado'],
				'codigo' => $codigo
			]);
		}

		$prazo = $user ? $user->prazo($exercicio) : false;

		return View('exercicio.show')->with('exercicio', $exercicio)
			->with('foraDoPrazo', $prazo ? $prazo->prazo <= now() : false)
			->with('respostaR', $respostaR)
			->with('codigo', $codigo);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\Contracts\View\View
	 */
	public function edit(Exercicio $exercicio)
	{
		$this->authorize('edit', $exercicio);
		return View('exercicio.edit')
			->with('exercicio', $exercicio)
			->with('exercicio.testes', $exercicio->testes)
			->with('topicos', Topico::orderBy('order')->get())
			->with('pacotesR', $this->getInstalledPackages());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Exercicio $exercicio)
	{
		$this->authorize('edit', $exercicio);
		$data = $this->validateRequest($request, $exercicio);

		// store
		DB::transaction(function () use ($data, $exercicio) {
			$exercicio->update($data);
			$exercicio->testes()->delete(); // delete all testes because we're lazy
			$n = count($data['dicas']);
			for ($i = 0; $i < $n; $i++) {
				$teste = Teste::create([
					'condicao' => $data['condicoes'][$i],
					'dica' => $data['dicas'][$i],
					'peso' => $data['pesos'][$i],
					'exercicio_id' => $exercicio->id
				]);
			}
		});

		// testa as preconds
		$test = $this->corretoR($exercicio, "/usr/local/src/notar/runtest.R");
		if ($test['status'] == 'danger') {
			return redirect()->action(
				[ExercicioController::class, 'edit'],
				['exercicio' => $exercicio]
			)->withErrors(
				['precondicoes' => 'Ocorreu um erro ao testar as precondições.']
			);
		}

		return redirect()->action(
			[ExercicioController::class, 'show'],
			['exercicio' => $exercicio]
		);
	}

	/**
	 * Export to text file
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function export(int $id)
	{
		$exercicio = Exercicio::with('testes')->find($id);
		$this->authorize('edit', $exercicio);

		try {
			$filename = TmpFile::generateTmpFileName('notaR_exercicio' . $exercicio->name, '.yaml');
			Storage::put($filename, $exercicio->export());
		} catch (Exception $e) {
			return back()->withErrors('Erro ao exportar exercício.');
		}
		;
		return response()->download($filename)->deleteFileAfterSend(true);
	}

	/** Export all exercicios
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function exportAll()
	{
		$this->authorize('bulk', Exercicio::class);

		// Create files for each model
		// Create a file containing all of that
		$exercicios = Exercicio::with('testes')->get();
		$filename = TmpFile::generateTmpFileName('notaR_exercicios', '.zip');

		try {
			$zip = new ZipArchive;
			if ($zip->open($filename, ZipArchive::CREATE) === TRUE) {
				foreach ($exercicios as $key => $value) {
					$fn = Str::slug($value->name) . '.yaml';
					$zip->addFromString($fn, $value->export());
				}
				$zip->close();
			}
		} catch (Exception $e) {
			return back()->withErrors('Erro ao exportar exercícios.');
		}
		;
		return response()->download($filename)->deleteFileAfterSend(true);
	}

	private function importInput($data)
	{
		$input = ['from_import' => true];
		if (property_exists($data, 'testes')) {
			$testes = collect($data->testes);
			$input = [
				'dicas' => $testes->pluck('dica'),
				'condicoes' => $testes->pluck('condicao'),
				'pesos' => $testes->pluck('peso'),
				'from_import' => true
			];
		}

		if (property_exists($data, 'name')) {
			$input['name'] = $data->name;
		}

		if (property_exists($data, 'description')) {
			$input['description'] = $data->description;
		}

		if (property_exists($data, 'precondicoes')) {
			$input['precondicoes'] = $data->precondicoes;
		}

		return $input;
	}

	/**
	 * Import from yaml file
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function importEdit(Request $request, Exercicio $exercicio)
	{
		$this->authorize('edit', $exercicio);
		$request->validate([
			'file' => 'required',
		]);

		$j = $request->file('file')->get();

		$data = Yaml::parse($j);
		if (is_null($data)) {
			return redirect()->action(
				[ExercicioController::class, 'edit'],
				['exercicio' => $exercicio]
			)->withErrors(['file' => 'O arquivo enviado não é um json válido']);
		}

		return redirect()->action(
			[ExercicioController::class, 'edit'],
			['exercicio' => $exercicio]
		)->withInput($this->importInput((object) $data));
	}


	/**
	 * Import from json file
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function import(Request $request)
	{
		$this->authorize('create', Exercicio::class);
		$request->validate([
			'file' => 'required',
		]);

		$j = $request->file('file')->get();

		$data = Yaml::parse($j);
		if (is_null($data)) {
			return redirect()->action([ExercicioController::class, 'create'])
				->withErrors(['file' => 'O arquivo enviado não é um yaml válido']);
		}

		return redirect()->action([ExercicioController::class, 'create'])
			->withInput($this->importInput((object) $data));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Exercicio  $exercicio
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Exercicio $exercicio)
	{
		$this->authorize('delete', $exercicio);
		$exercicio->testes()->delete();
		$exercicio->delete();
		return redirect()->action([ExercicioController::class, 'index']);
	}
}
