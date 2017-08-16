<?php

namespace App\Support\Tweets;

use App\Street;
use App\Support\Traits\CommandTrait;
use App\Tweet;

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
        $this->report('Parsing..', 'comment');

        $results = collect(config('streets.map'))->transform(function ($strings, $street) {
            return collect($strings)->first(function ($string) {
                return (strpos($this->sanitize($this->tweet->text), $string) !== false);
            });
        })->filter()->keys();

        $this->report('Found ' . $results->count() . ' streets in tweet "' . $this->tweet->twitter_id . '".');

        $results->each(function ($slug) {
            $this->tweet->streets()->save(Street::where('slug', $slug)->first(), ['date' => $this->tweet->date]);
        });

        $this->tweet->processed = true;
        $this->tweet->save();

        return $results->toArray();
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
