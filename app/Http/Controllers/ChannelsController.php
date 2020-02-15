<?php

namespace App\Http\Controllers;

use App\Channels;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    //

    function show()
    {
        $channels = Channels::orderBy('subscribers', 'desc')->get();
        foreach ($channels as $channel) {
            $channel['videos'] = Channels::find($channel['id'])->videos()->orderBy('views', 'desc')->take(3)->get();
        }

        return view('home')->with('channels', $channels);
    }
}
