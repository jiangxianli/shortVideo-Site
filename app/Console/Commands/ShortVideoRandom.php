<?php

namespace App\Console\Commands;

use App\Module\SpiderModule;
use Illuminate\Console\Command;

class ShortVideoRandom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:short-video-random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '给每个视频生产随机数';

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
        $docid = $this->option('docid');
        if ($docid) {
            //V_00TU5W5p
            SpiderModule::spiderYidianItem($docid);
        } else {
            SpiderModule::spiderLastestYidian();
        }
    }
}
