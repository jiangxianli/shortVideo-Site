<?php
namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * BelongsTo ShortVideo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author  jiangxianli
     * @created_at 2016-10-29 13:44:27
     */
    public function shortVideo()
    {
        return $this->belongsToMany(__NAMESPACE__. '\ShortVideo', 'short_video_tag', 'short_video_id', 'tag_id');
    }

    /**
     * HasMany ShortVideoTag
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author  jiangxianli
     * @created_at 2016-10-29 15:17:08
     */
    public function shortVideoTag()
    {
        return $this->hasMany(__NAMESPACE__.'\ShortVideoTag', 'tag_id', 'id');
    }

    /**
     * 标签相关视频个数统计
     *
     * @return int
     * @author  jiangxianli
     * @created_at 2016-10-29 15:21:30
     */
    public function shortVideoCount()
    {
        $short_video_tags = $this->shortVideoTag;
        $short_video_arr  = [];
        foreach ($short_video_tags as $short_video_tag) {
            if (!in_array($short_video_tag->short_video_id, $short_video_arr)) {
                $short_video_arr[] = $short_video_tag->short_video_id;
            }
        }
        return count($short_video_arr);
    }

}
