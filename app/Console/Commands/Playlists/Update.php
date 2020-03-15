<?php

namespace App\Console\Commands\Playlists;

use Carbon\Carbon;
use App\Channels;
use App\Console\Commands\Youtube;

class Update extends Youtube
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playlist:update {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Playlist';

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
            $channel = Channels::where('id', $this->option('id'));
        } else {
            $channels = Channels::all();
            $choice = $this->choice('請選擇：', $channels->pluck('name', 'id')->toArray());
            $channel = Channels::Where('name', '=', $choice)->first();
        };

        // next page token
        $nextPageToken = '';

        while (!is_null($nextPageToken)) {

            /**
             * @return Google_Service_YouTube_PlaylistItemListResponse
             */
            $playlist = $this->youtube->playlistItems->listPlaylistItems(
                'snippet', [
                    'playlistId' => $channel->playlist,
                    'maxResults' => 50, // range in [0, 50]
                    'pageToken' => $nextPageToken
                ]
            );

            $newUid = [];

            /**
             * get video data
             * https://developers.google.com/youtube/v3/docs/playlistItems
             */
            foreach ($playlist->getItems() as $videos) {
                //title describe video_id uid published_at
                $snippet = $videos->getSnippet();
                $uid = $snippet->getResourceId()->getVideoId();
                $title = $snippet->getTitle();
                $description = $snippet->getDescription();
                $published_at = $snippet->getPublishedAt();

                $video = $channel->videos()->where('uid', '=', $uid);

                if (!$video->exists()) {
                    $this->info('Create new video: ' . $title);

                    $channel->videos()->create([
                        'uid' => $uid,
                        'name' => $title,
                        'description' => $description,
                        'views' => 0,
                        'likes' => 0,
                        'dislikes' => 0,
                        'favorites' => 0,
                        'comments' => 0,
                        'priority' => 0,
                        'published_at' => Carbon::parse($published_at),
                        'updated_at' => Carbon::now()
                    ]);

                    $newUid[] = $uid;
                } else if (!$video->where('name', $title)->where('description', $description)->exists()) {
                    $channel->videos()->where('uid', '=', $uid)->update([
                        'name' => $title,
                        'description' => $description
                    ]);

                    continue;
                }
            }

            $nextPageToken = $playlist->getNextPageToken();
        }
    }
}
