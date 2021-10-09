<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client as Guzzle;

class LoadTest extends Command
{
        /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loadtest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts a load test against production.';

    public function get()
    {
        $this->info('Firing GET requests.');
        $sent = 500;
        $received = 0;
        $client = new Guzzle();
        for ($i = 0; $i < $sent; $i++) {
            $response = $client->request('GET', 'http://notar.ib.usp.br/exercicio/29');
            if($response->getStatusCode() === 200) {
                $received++;
            }
            echo '.';
        }
        echo "\n";
        $this->info("Sent ${sent}, received ${received}");
    }

    public function post()
    {
        $this->info('Firing POST requests.');
        $sent = 500;
        $received = 0;
        $client = new Guzzle();
        for ($i = 0; $i < $sent; $i++) {
            $response = $client->request(
                'POST',
                'http://notar.ib.usp.br/exercicio/29',
                [
                    'http_errors' => false,
                    'form_params' => [
                         'codigo' => 'x <-1',
                         'token' => 'T2X3inzuoXsDwIwy7KThMr9jhgi6nb3fh6kAT2RZ', // TO DO???
                     ],
                ]
            );
            if($response->getStatusCode() === 200) {
                $received++;
            }
            echo '.';
        }
        echo "\n";
        $this->info("Sent ${sent}, received ${received}");
    }

    public function handle()
    {
        $this->info('Load test starting!');
        $this->get();
        $this->post();
        $this->info('Load test finished!');
        return TRUE;
    }
}