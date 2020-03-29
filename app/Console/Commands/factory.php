<?php

namespace App\Console\Commands;

use App\Models\Phone;
use Illuminate\Console\Command;

class factory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factory:fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popular Banco de dados';

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
        factory(Phone::class,10)->create();
    }
}
