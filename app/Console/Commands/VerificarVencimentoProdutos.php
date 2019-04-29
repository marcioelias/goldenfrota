<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VencimentoProdutoController;

class VerificarVencimentoProdutos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produtos:vencimento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica o vencimento de produtos utilizados em veiculos';

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
        (new VencimentoProdutoController)->verificarVencimentoProdutos();
    }
}
