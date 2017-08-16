<?php

namespace App\Console\Commands;

use App\Support\Tweets\TweetFetcher;
use Illuminate\Console\Command;

class LatestTweetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radar:latest {mode=manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the latest tweets.';

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
        $mode =  $this->argument('mode');

        (new TweetFetcher())->setCommand($this)->fetchLatestTweets(true, $mode);
    }
}
