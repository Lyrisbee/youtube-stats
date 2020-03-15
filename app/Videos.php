<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Channels;
use App\VideosStatistics;

class Videos extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $dates = [
        'published_at',
        'updated_at'
    ];

    //
    public function channels()
    {
        return $this->belongsTo(Channels::class, 'id');
    }

    public function statistics()
    {
        return $this->hasMany(VideoStatistics::class, 'video_id');
    }
}
