<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tweets = collect(['895910011335004160','895587871653978112','895174512542666755','894811999481278465','894456800292065280','893373524487933953','893002880038424576','892641722563428352','892328310453174272','891911006334660608','890863107010158592','890130180353777664','889736885500874752','889390291165339648','876796786802872322','857470897023832065','846721897421262854','846619759517077504','844555896168566785','844208863930974209','843718461142503424']);

        $tweets->each(function ($tweet) {
            try {
                $response = Twitter::getTweet($tweet, ['tweet_mode' => 'extended']);
            } catch (Exception $e) {
                dd(Twitter::logs());
            }

            return App\Tweet::create([
                'twitter_id' => $response->id_str,
                'text' => $response->full_text,
                'raw_date' => $response->created_at
            ]);
        });
    }
}
