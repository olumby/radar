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

        $results = [];

        foreach (config('streets.map') as $street => $matches) {
            foreach ($matches as $match) {
                if (strpos($this->sanitize($this->tweet->text), $match) !== false) {
                    $this->report('Matches - ' . $street);
                    $results[] = $street;
                    break;
                }
            }
        }

        $this->report('');
        $this->report('');

        $this->report($this->sanitize($this->tweet->text));

        return $results;
    }

    private function sanitize($str)
    {
        $str = $this->stripAccents($str);
        $str = $this->removeLinks($str);
        $str = $this->cleanRoadAbbriviations($str);
        $str = strtolower($str);

        return trim($str);
    }

    private function cleanRoadAbbriviations($str)
    {
        $str = str_ireplace('a l?', '', $str);
        $str = str_ireplace('gs.', 'germans', $str);
        $str = str_ireplace('grl.', 'general', $str);

        $str = str_ireplace('gs .', 'germans', $str);
        $str = str_ireplace('grl .', 'general', $str);

        $str = str_ireplace('gs', 'germans', $str);
        $str = str_ireplace('grl', 'general', $str);

        $str = str_ireplace('av. ', 'a.', $str);
        $str = str_ireplace('av .', 'a.', $str);
        $str = str_ireplace('a .', 'a.', $str);
        $str = str_ireplace('a. ', 'a.', $str);
        $str = str_ireplace('av.', 'a.', $str);

        $str = str_ireplace('c. ', 'c.', $str);
        $str = str_ireplace('c .', 'c.', $str);

        $str = str_ireplace('m. ', 'm.', $str);
        $str = str_ireplace('m. ', 'm.', $str);

        $str = str_ireplace('gr. ', 'gr.', $str);
        $str = str_ireplace('gr. ', 'gr.', $str);

        $str = str_ireplace('avgda.', 'a.', $str);
        $str = str_ireplace('avgda .', 'a.', $str);
        $str = str_ireplace('avgda ', 'a.', $str);
        $str = str_ireplace('avgda', 'a.', $str);

        return $str;
    }

    private function removeLinks($str)
    {
        $str = preg_replace('/(^|\s)@(\w+)/', '', $str);
        $str = preg_replace('/(#\w+)/', '', $str);
        return preg_replace('/http(s?):\/\/t.co\/[a-zA-Z0-9\-\.]+/', '', $str);
    }

    private function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}
