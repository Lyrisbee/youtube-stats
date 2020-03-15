<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Videos;

class VideoStatistics extends Model
{
    //
    public $timestamps = false;

    protected $guarded = [];

    protected $dates = [
        'fetch_at'
    ];

    public function video()
    {
        $this->belongsTo(Videos::class);
    }
}
