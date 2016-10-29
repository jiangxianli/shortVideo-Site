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
        return $this->belongsTo(__NAMESPACE__, '\ShortVideo', 'short_video_tag', 'tag_id', 'short_video_id');
    }
}
