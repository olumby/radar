<?php

namespace App\Support\Tweets;

use App\Street;
use App\Tweet;

class TweetReparser
{
    protected $tweet;

    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    public function reparse()
    {
        $this->tweet->streets()->detach();

        $tweetParser = new TweetParser($this->tweet);

        $tweetParser->parse();
    }
}
