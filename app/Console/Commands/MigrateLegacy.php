<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateLegacy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:legacy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports legacy data to this installation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement("
        INSERT INTO exercicios (id, `name`, `description`, precondicoes)
        SELECT id_exercicio, nome, html, precondicoes
        FROM notar_legacy.exercicio
        WHERE nome != '';
        ");
        DB::statement("
        INSERT INTO testes (id, condicao, dica, peso, exercicio_id)
        SELECT id_teste, condicao, dica, peso, id_exercicio
        FROM notar_legacy.teste JOIN notar_legacy.exercicio USING (id_exercicio)
        WHERE nome != ''
        ORDER BY ordem ASC;
        ");

        $this->info('Legacy data imported!');

        return 0;
    }
}
