<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AnalisaController;
class SetIsGone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pasien:isGone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting is gone = 1 agar tidak dapat diedit';

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
        $analisaController = new AnalisaController();
        $analisaController->setIsGone();
        $analisaController->doAnalisa();
    }
}
