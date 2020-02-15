<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Channels;

class videos extends Model
{
    //
    public function channels()
    {
        return $this->belongsTo(Channels::class, 'id');
    }
}
