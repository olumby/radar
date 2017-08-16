<?php

namespace App\Support\Tweets;

use App\Activity;
use App\Support\Traits\CommandTrait;
use App\Support\Tweets\TweetParser;
use App\Tweet;
use Carbon\Carbon;
use Thujohn\Twitter\Facades\Twitter;

class TweetFetcher
{
    use CommandTrait;

    public function fetchLatestTweets($parse = true, $mode = 'manual')
    {
        $this->report('Fetching latest tweets..', 'comment');
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
            $this->report('Using "' . $latest->latest_id . '" as "since_id".', 'comment');
        }

        try {
            $response = Twitter::getSearch($params);
        } catch (Exception $e) {
            dd(Twitter::logs());
        }

        $this->report('Found ' . count($response->statuses) . ' tweets..', 'comment');

        $tweets = collect($response->statuses)->reverse()->transform(function ($status) use ($parse) {
            if (Tweet::where('twitter_id', $status->id_str)->count() == 0) {
                $tweet = Tweet::create([
                    'twitter_id' => $status->id_str,
                    'text' => $status->full_text,
                    'date' => Carbon::parse($status->created_at)->format('Y-m-d H:i:s')
                ]);

                if ($parse) {
                    $tweetParser = new TweetParser($tweet);

                    if (isset($this->command)) {
                        $tweetParser->setCommand($this->command);
                    }

                    $tweetParser->parse();
                }

                return $tweet->twitter_id;
            }

            return null;
        })->filter();

        Activity::create([
            'tweet_count' => $tweets->count(),
            'latest_id' => $tweets->last(),
            'mode' => $mode
        ]);

        $this->report('Finished', 'info');
    }

    public function fetchTweets($ids, $parse = true, $mode = 'seed')
    {
        asort($ids);

        $tweets = collect($ids)->each(function ($id) use ($parse) {
            return $this->fetchTweet($id, $parse);
        });

        Activity::create([
            'tweet_count' => $tweets->count(),
            'latest_id' => $tweets->last(),
            'mode' => $mode
        ]);
    }

    public function fetchTweet($id, $parse = true)
    {
        try {
            $response = Twitter::getTweet($id, ['tweet_mode' => 'extended']);
        } catch (Exception $e) {
            dd(Twitter::logs());
        }

        $tweet = Tweet::create([
            'twitter_id' => $response->id_str,
            'text' => $response->full_text,
            'date' => Carbon::parse($response->created_at)->format("Y-m-d H:i:s")
        ]);

        if ($parse) {
            $tweetParser = new TweetParser($tweet);
            
            if (isset($this->command)) {
                $tweetParser->setCommand($this->command);
            }

            $tweetParser->parse();
        }

        return $tweet;
    }
}
