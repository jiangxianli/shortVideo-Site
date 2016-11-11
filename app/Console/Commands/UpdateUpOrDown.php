<?php

namespace App\Console\Commands;

use App\Module\ShortVideoModule;
use App\Module\SpiderModule;
use Illuminate\Console\Command;

class UpdateUpOrDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-up-or-down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UpdateUpOrDown';

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
        $command = $this;
        $command->out = $this->output;
        SpiderModule::updateUpOrDown($command);
    }
}
