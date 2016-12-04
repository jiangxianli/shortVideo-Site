<?php

namespace App\Console\Commands;

use App\Module\QiniuModule;
use Illuminate\Console\Command;

class UploadToQiniu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:upload-to-qiniu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '上传文件到七牛';

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
        $command      = $this;
        $command->out = $this->output;
        QiniuModule::uploadToQiniu();
    }
}
