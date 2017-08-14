<?php

namespace App\Console\Commands;

use App\Activity;
use Illuminate\Console\Command;
use Thujohn\Twitter\Facades\Twitter;

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
        $latest = Activity::latest()->first();

        // If latest..
        try {
            $response = Twitter::getSearch(['q' => '#radarPLV', 'from' => 'policialocalvlc', 'result_type' => 'recent', 'count' => '20', 'tweet_mode' => 'extended']);
        } catch (Exception $e) {
            dd(Twitter::logs());
        }

        dd(count($response->statuses));
    }
}
