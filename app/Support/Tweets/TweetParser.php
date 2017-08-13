<?php

namespace App\Support\Tweets;

use App\Tweet;
use App\Support\Traits\CommandTrait;

class TweetParser
{
    use CommandTrait;

    protected $tweet;

    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    public function parse()
    {
        $this->report('Parsing tweet:', 'comment');
        $this->report($this->tweet->text);
        $this->report('');
        $this->report('');

        $this->report($this->sanitize($this->tweet->text));
    }

    private function sanitize($str)
    {
        $str = $this->stripAccents($str);
        $str = strtolower($str);

        return $str;
    }

    private function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
