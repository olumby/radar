<?php

use App\Support\Tweets\TweetFetcher;
use Illuminate\Database\Seeder;

class TweetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ids = ['895910011335004160', '895587871653978112', '895174512542666755', '894811999481278465', '894456800292065280', '893373524487933953', '893002880038424576', '892641722563428352', '892328310453174272', '891911006334660608', '890863107010158592', '890130180353777664', '889736885500874752', '889390291165339648'];
        
        (new TweetFetcher())->fetchTweets($ids);
    }
}
