<?php

namespace App\Console\Commands;

use App\Module\SpiderModule;
use Illuminate\Console\Command;

class SpiderYidian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:spider-yi-dian {--init=}';

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
        $init = $this->option('init');
        if($init){
            SpiderModule::spiderYidianItem('V_00TU5W5p');
        }else{
            SpiderModule::spiderLastestYidian();
        }
    }
}
