<?php
namespace App\Module;

use App\Factory\ShortVideoFactory;
use Illuminate\Support\Facades\Cache;

class SpiderModule
{

    public static function spiderYidianItem($platform_id, callable $callback = null)
    {
        //http://124.243.203.100/Website/contents/content?docid=V_00TU5W5p&version=020109
        $url      = 'http://124.243.203.100/Website/contents/content?docid=' . $platform_id . '&recommend_video=true&version=020109';
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        \Log::info($response);
        if ($response['code'] == 0) {

            $documents = $response['documents'][0];

            $short_video = ShortVideoFactory::shortVideoModel();
            $arr         = [
                'url'           => $documents['video_url'],
                'poster'        => $documents['image'],
                'platform_id'   => $documents['docid'],
                'platform_type' => 1,
                'title'         => $documents['title']
            ];
            $short_video = $short_video->where([
                'platform_id'   => $arr['platform_id'],
                'platform_type' => $arr['platform_id']
            ])->first();
            if ($short_video) {
                return;
            }
            $short_video = ShortVideoFactory::shortVideoModel();
            $short_video->fill($arr);
            $short_video->save();

            $tag_id_arr = [];
            foreach ($documents['keywords'] as $value) {
                $tag          = ShortVideoFactory::tagModel()->firstOrCreate(['name' => $value]);
                $tag_id_arr[] = $tag->id;
            }

            foreach ($documents['vsct_show'] as $value) {
                $tag          = ShortVideoFactory::tagModel()->firstOrCreate(['name' => $value]);
                $tag_id_arr[] = $tag->id;
            }

            $short_video->tags()->sync($tag_id_arr);
            \Log::info($url);
            if (is_callable($callback)) {

                $callback();

            }

            foreach ($documents['recommend_video'] as $recommend_video) {
                self::spiderYidianItem($recommend_video['docid'], $callback);
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

}