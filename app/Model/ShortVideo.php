<?php
namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShortVideo extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'short_video';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'poster', 'platform_id', 'platform_type', 'title', 'random'
    ];

    /**
     * BelongsToMany Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author  jiangxianli
     * @created_at　
     */
    public function tags()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\Tag', 'short_video_tag', 'short_video_id', 'tag_id');
    }
}
