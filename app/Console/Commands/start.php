<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:app';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $task = $this->choice("Foi criado o '.env'?", ['S', 'N'], 0);
        if ($task == 'N') exit;

        $db = $this->choice("Configurou as credênciais do banco MYSQL?", ['S', 'N'], 0);
        if ($db == 'N') exit;

        $this->callSilent('config:cache');
        $this->call('db:create');
        $this->comment('Banco criado.');

        $this->callSilent('key:generate');
        $this->comment('Chave criada.');

        $this->callSilent('config:cache');

        $this->callSilent('migrate'); //--seed
        $this->comment('Migrações realizadas.');

        $this->callSilent('db:seed');
        $this->comment('Banco populado.');

        $this->call('factory:fake');
        $this->comment('Dados fakes inseridos.');

        $headers = ['Usuário', 'Senha'];

        $this->comment('');
        $this->alert('Usuário administrador');

        $users = [['admin@admin.com', '123456']];
        $this->table($headers, $users);

    }
}
