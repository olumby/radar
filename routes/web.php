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

Route::get('/', function () {


    try {
        //$response = Twitter::getUserTimeline(['screen_name' => 'policialocalvlc', 'count' => 20, 'format' => 'array']);
        $response = Twitter::getSearch(['q' => '#radarPLV', 'from' => 'policialocalvlc', 'result_type' => 'recent', 'count' => '20', 'since_id' => '865094259761967104']);
    } catch (Exception $e) {
        // dd(Twitter::error());
        dd(Twitter::logs());
    }

    foreach ($response->statuses as $status) {
        App\Tweet::create([
            'twitter_id' => $status->id_str,
            'text' => $status->text,
            'raw_date' => $status->created_at
        ]);
    }

    dd($response);
});

Route::get('/tweet/{id}', function ($id) {

    try {
        $response = Twitter::getTweet($id);
    } catch (Exception $e) {
        dd(Twitter::logs());
    }

    $tweet = App\Tweet::create([
        'twitter_id' => $response->id_str,
        'text' => $response->text,
        'raw_date' => $response->created_at
    ]);

    return $tweet;

});


Route::get('tweets', function () {

    $tweets = App\Tweet::get(['twitter_id', 'text', 'raw_date']);

    return $tweets->toArray();


});
