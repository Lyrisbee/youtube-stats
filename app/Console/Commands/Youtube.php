<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Youtube extends Command
{
    /**
     * The console command name
     *
     * @var string
     */
    protected $name = 'Youtube';

    protected $youtube;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->youtube = app('youtube');
    }
}
