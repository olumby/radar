<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/store/latest', function () {
    try {
        $response = Twitter::getSearch(['q' => '#radarPLV', 'from' => 'policialocalvlc', 'result_type' => 'recent', 'count' => '20', 'tweet_mode' => 'extended']);
    } catch (Exception $e) {
        dd(Twitter::logs());
    }

    $tweets = collect($response->statuses)->transform(function ($status) {
        return App\Tweet::create([
            'twitter_id' => $status->id_str,
            'text' => $status->full_text,
            'raw_date' => $status->created_at
        ]);
    });

    return $tweets;
});

Route::get('/store/tweet/{id}', function ($id) {
    try {
        $response = Twitter::getTweet($id, ['tweet_mode' => 'extended']);
    } catch (Exception $e) {
        dd(Twitter::logs());
    }

    $tweet = App\Tweet::create([
        'twitter_id' => $response->id_str,
        'text' => $response->full_text,
        'raw_date' => $response->created_at
    ]);

    return $tweet;
});


Route::get('tweets', function () {
    $tweets = App\Tweet::get(['twitter_id', 'text', 'raw_date']);

    return $tweets->toArray();
});


Route::get('visual', function() {
    $tweets = App\Tweet::get(['twitter_id', 'text', 'raw_date'])->transform(function ($tweet) {
        $tweetParser = new App\Support\Tweets\TweetParser($tweet);

        return [
            'text' => $tweet->text,
            'parsed' => $tweetParser->parse()
        ];
    });


    return view('visual', compact('tweets'));
});
