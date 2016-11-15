<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;
use App\Helper\CURL;
use Illuminate\Support\Facades\Cache;

class SpiderModule
{

    /**
     * 抓取单个一点视频
     *
     * @param $platform_id
     * @param int $count
     * @author  jiangxianli
     * @created_at 2016-10-27 18:41:20
     */
    public static function spiderYidianItem($platform_id, $count = 0)
    {
        //http://124.243.203.100/Website/contents/content?docid=V_00TU5W5p&version=020109
        $url = 'http://124.243.203.100/Website/contents/content?docid=' . $platform_id . '&recommend_video=true&version=020109';
//        $response = file_get_contents($url);
        $response = CURL::get($url);
        $response = json_decode($response, true);
        \Log::info($response);
        if ($response['code'] == 0) {

            $documents = $response['documents'][0];

            if (!$documents['video_url'] || !$documents['title']) {
                return;
            }

            $short_video = ShortVideoFactory::shortVideoModel();
            $arr         = [
                'url'           => $documents['video_url'],
                'poster'        => $documents['image'],
                'platform_id'   => $documents['docid'],
                'platform_type' => 1,
                'title'         => $documents['title'],
                'random'        => str_random(rand(16, 32))
            ];
            $short_video = $short_video->where([
                'platform_id'   => $arr['platform_id'],
                'platform_type' => $arr['platform_id']
            ])->first();
            if (!$short_video) {

                $short_video = ShortVideoFactory::shortVideoModel();
                $short_video->fill($arr);
                $short_video->save();

                $tag_id_arr = [];
                if (isset($documents['keywords'])) {
                    foreach ($documents['keywords'] as $value) {
                        $tag          = ShortVideoFactory::tagModel()->firstOrCreate(['name' => $value]);
                        $tag_id_arr[] = $tag->id;
                    }

                }

                if (isset($documents['vsct_show'])) {
                    foreach ($documents['vsct_show'] as $value) {
                        $tag          = ShortVideoFactory::tagModel()->firstOrCreate(['name' => $value]);
                        $tag_id_arr[] = $tag->id;
                    }
                }

                $short_video->tags()->sync($tag_id_arr);
                \Log::info($url);

                if ($count >= 1000) {
                    return;
                }
                $count++;
                \Log::info($count);

                if (isset($documents['recommend_video'])) {
                    foreach ($documents['recommend_video'] as $recommend_video) {
                        $short_video = ShortVideoFactory::shortVideoModel()->where([
                            'platform_id'   => $recommend_video['docid'],
                            'platform_type' => 1
                        ])->first();
                        if (!$short_video) {
                            self::spiderYidianItem($recommend_video['docid'], $count);
                        }
                    }
                }

                sleep(1);

            }
        }
    }

    public static function spiderLastestYidian()
    {

        $not_in_items = (array)Cache::get('spider-yi-dian');

        $short_video = ShortVideoFactory::shortVideoSearch([
            'not_in_items' => [
                'id' => $not_in_items
            ]
        ])->take(100)->get();

        foreach ($short_video as $item) {
            self::spiderYidianItem($item->platform_id, function () use ($not_in_items, $item) {
                array_push($not_in_items, $item->platform_id);
                Cache::forever('spider-yi-dian', $not_in_items);
            });
        }
    }


    public static function updateUpOrDown($command)
    {
        $per_page = 1000;
        $count    = ShortVideoFactory::shortVideoModel()->whereIn('up', [0, -1])->count();
        $command->out->progressStart($count);
        $last_page = ceil($count / $per_page);
        for ($i = 1; $i <= $last_page; $i++) {
            $short_videos = ShortVideoFactory::shortVideoModel()->whereIn('up', [0, -1])->orderBy('up', 'desc')->skip(($i - 1) * $per_page)->take($per_page)->get();
            foreach ($short_videos as $short_video) {
                $url      = 'http://124.243.203.100/Website/contents/content?docid=' . $short_video->platform_id . '&version=020109';
                $response = CURL::get($url);
                $response = json_decode($response, true);
                if ($response['code'] == 0) {
                    $documents = $response['documents'][0];
                    if (isset($documents['up']) && isset($documents['down']) && $documents['up'] && $documents['down']) {
                        \Log::info($short_video->platform_id . '--' . $documents['up'] . '---' . $documents['down']);
                        $short_video->up   = $documents['up'];
                        $short_video->down = $documents['down'];
                        $short_video->save();
                    } else {
                        $short_video->up   = -1;
                        $short_video->down = -1;
                        $short_video->save();
                    }

                }
                \Log::info($short_video->platform_id);
                $command->out->progressAdvance();
                sleep(1);
            }

        }
        $command->out->progressFinish();

    }

}