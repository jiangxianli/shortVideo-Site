<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class QiniuModule
{

    public static function uploadToQiniu()
    {
        $total     = ShortVideoFactory::shortVideoModel()->where('qiniu_key', '')->count();
        $per_page  = 200;
        $last_page = intval($total / $per_page) + 1;

        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = env('QINIU_ACCESS_KEY');
        $secretKey = env('QINIU_SECRET_KEY');

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);
        // 要上传的空间
        $bucket = env('QINIU_BUCKET');

        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();
        echo "====================总共" . $total . "个文件===========================\n";
        $index = 0;

        for ($i = 1; $i <= $last_page; $i++) {

            // 生成上传 Token
            $token = $auth->uploadToken($bucket);

            $short_videos = ShortVideoFactory::shortVideoModel()
                ->where('qiniu_key', '')
                ->orderBy('up', 'desc')
                ->skip(($i - 1) * $per_page)
                ->take($per_page)
                ->get();
            foreach ($short_videos as $short_video) {

                try {

                    $url            = $short_video->url;
                    $title          = $short_video->title;
                    $file_extension = substr($url, strrpos($url, '.'));

                    $index++;
                    $percent = round($index / $total, 2);

                    echo $index . ".============" . $percent . "%==============\n";
                    echo "URL:" . $url . "\n";
                    echo "TITLE:" . $title . "\n";
                    echo "Extension:" . $file_extension . "\n";
                    $key = $title . '.' . $file_extension;
                    $key = str_replace('..', '.', $key);

                    $tmp_dir = storage_path('tmp');
                    if (!file_exists($tmp_dir)) {
                        mkdir($tmp_dir, 0755, true);
                    }

                    $tmp_path = $tmp_dir . '/' . $key;
                    $tmp_path = str_replace('//', '/', $tmp_path);

                    echo "==================下载文件=========================\n";
                    $file_content = file_get_contents($url);
                    echo "==================创建文件=========================\n";
                    file_put_contents($tmp_path, $file_content);

                    // 调用 UploadManager 的 putFile 方法进行文件的上传
                    echo "==================上传文件=========================\n";
                    list($ret, $err) = $uploadMgr->putFile($token, $key, $tmp_path);
                    echo "==================上传失败=========================\n";
                    if ($err !== null) {
                        var_dump($err);
                    } else {
                        var_dump($ret);
                        echo "==================上传成功=========================\n";
                        $short_video->qiniu_key  = $ret['key'];
                        $short_video->qiniu_hash = $ret['hash'];
                        $short_video->save();
                    }

                    exec('rm -rf ' . $tmp_dir);

                } catch (\Exception $exception) {
                    echo "==================系统错误=========================\n";
                    var_dump($exception->getMessage());
                }
            }
        }
    }

}