<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Channels;

class Videos extends Model
{
    //
    public function channels()
    {
        return $this->belongsTo(Channels::class, 'id');
    }
}
