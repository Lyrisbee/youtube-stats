<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Channels;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function show(Request $request, $uid)
    {
        return view('channel')->with('channel', Channels::where('uid', $uid)->firstOrFail());
    }

    public function playlists(Request $request, $uid)
    {
        $channel = Channels::where('uid', $uid)->firstOrFail();
        $channel->playlists = $channel->videos()->orderBy('views', 'desc')->paginate(15);
        foreach($channel->playlists as $Ind => $video) {
            $video->create_at = Carbon::parse($video->published_at)->diffForHumans();
        }

        return view('channel')->with('channel', $channel);
    }
}
