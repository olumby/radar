<?php

namespace App\Console\Commands;

use App\Activity;
use App\Support\Tweets\TweetParser;
use App\Tweet;
use Carbon\Carbon;
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
        $this->comment('Fetching latest tweets..');
        $latest = Activity::whereNotNull('latest_id')->latest()->first();

        $params = [
            'q' => '#radarPLV',
            'from' => 'policialocalvlc',
            'result_type' => 'recent',
            'count' => '20',
            'tweet_mode' => 'extended'
        ];

        if ($latest) {
            $params['since_id'] = $latest->latest_id;
            $this->comment('Using "' . $latest->latest_id . '" as "since_id".');
        }

        try {
            $response = Twitter::getSearch($params);
        } catch (Exception $e) {
            dd(Twitter::logs());
        }

        $this->comment('Found ' . count($response->statuses) . ' tweets..');

        $tweets = collect($response->statuses)->reverse()->transform(function ($status) {
            if (Tweet::where('twitter_id', $status->id_str)->count() == 0) {
                $tweet = Tweet::create([
                    'twitter_id' => $status->id_str,
                    'text' => $status->full_text,
                    'date' => Carbon::parse($status->created_at)->format('Y-m-d H:i:s')
                ]);

                $tweetParser = new TweetParser($tweet);
                $tweetParser->setCommand($this)->parse();

                return $tweet->twitter_id;
            }

            return null;
        })->filter();

        Activity::create([
            'tweet_count' => $tweets->count(),
            'latest_id' => $tweets->last(),
            'mode' => $this->argument('mode')
        ]);

        $this->info('Finished');
    }
}
