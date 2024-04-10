<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MigrateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:admin {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an admin account if none exist';

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
        $admins = User::where('is_admin', true)->get();
        if (count($admins)) {
            throw new \InvalidArgumentException("There are already admin users registered.");
        }
        User::create([
            'email' => 'admin@notar.br',
            'name'  => 'Admin',
            'is_admin' => true,
            'password' => $this->argument('password')
        ]);

        $this->info('User admin@notar.br created!');

        return 0;
    }
}
