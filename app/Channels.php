<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Videos;

class Channels extends Model
{
    //
    protected $guarded = [];

    public function videos()
    {
        return $this->hasMany(Videos::class, 'channel_id');
    }

    public function statistics()
    {
        return $this->hasMany(ChannelsStatistics::class, 'channel_id');
    }
}
