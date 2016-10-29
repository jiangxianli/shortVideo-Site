<?php
namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShortVideoTag extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'short_video_tag';
}
