<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Videos;

class Channels extends Model
{
    //

    public function videos()
    {
        return $this->hasMany(Videos::class, 'channel_id');
    }
}
