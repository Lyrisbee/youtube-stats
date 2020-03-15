<?php

namespace App\Console\Commands\Video;

use App\Console\Commands\Youtube;
use App\Videos;
use Carbon\Carbon;

class Update extends Youtube
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:update {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update video information';

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
        if (is_null($this->option('id')))
        {
            $this->error('Not Found Video ID');
            exit();
        }

        $videos = $this->youtube->videos->listVideos('statistics', [
            'id' => $this->option('id')
        ]);

        /**
         * @var Google_Service_YouTube_Video
         */
        foreach($videos->getItems() as $video) {
            $statistics = $video->getStatistics();

            $comments = $statistics->getCommentCount();
            $dislikes = $statistics->getDislikeCount();
            $likes = $statistics->getLikeCount();
            $favorite = $statistics->getFavoriteCount();
            $views = $statistics->getViewCount();

            $mvideo = Videos::where('uid', $video->getId())->first();
            $mvideo->update([
                'views' => $views,
                'likes' => $likes,
                'dislikes' => $dislikes,
                'favorites' => $favorite,
                'comments' => $comments
            ]);

            $mvideo->statistics()->create([
                'views' => $views,
                'likes' => $likes,
                'dislikes' => $dislikes,
                'favorites' => $favorite,
                'comments' => $comments,
                'fetched_at' => Carbon::now()
            ]);
        }
    }
}
