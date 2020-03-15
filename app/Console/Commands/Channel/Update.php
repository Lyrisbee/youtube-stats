<?php

namespace App\Console\Commands\Channel;

use App\Channels;
use App\Console\Commands\Youtube;
use Carbon\Carbon;

class Update extends Youtube
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:update {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update channel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!is_null($this->option('id'))) {
            $channel = Channels::where('uid', '=', $this->option('id'))->firstOrFail();
        } else {
            $channels = Channels::all();
            $choice = $this->choice('請選擇：', $channels->pluck('name', 'id')->toArray());
            $channel = Channels::Where('name', '=', $choice)->firstOrFail();
        }
        $yt_channels = $this->youtube->channels->listChannels('statistics', [
            'id' => $channel->uid
        ]);

        foreach($yt_channels->getItems() as $item) {
            $statistics = $item->getStatistics();

            $viewCount = $statistics->getViewCount();
            $videoCount = $statistics->getVideoCount();
            $commentCount = $statistics->getCommentCount();
            $subCount = $statistics->getSubscriberCount();

            $mchannel = Channels::Where('uid', $channel->uid)->firstOrFail();
            $mchannel->update([
                'subscribers' => $subCount,
                'views' => $viewCount,
                'videos' => $videoCount,
                'comments' => $commentCount
            ]);

            $mchannel->statistics()->create([
                'subscribers' => $subCount,
                'views' => $viewCount,
                'videos' => $videoCount,
                'comments' => $commentCount,
                'fetched_at' => Carbon::now()
            ]);
        }

    }
}
