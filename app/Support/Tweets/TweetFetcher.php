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

    public function fetchLatestTweets($parse = true)
    {
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
