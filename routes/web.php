<?php

$router->get('/', 'HomeController@index');

$router->get('dev', 'HomeController@dev');

$router->get('tweets', 'TweetController@index');
$router->get('tweet/{tweet}', 'TweetController@show');

$router->group(['middleware' => 'auth.very_basic'], function () use ($router) {
    $router->get('admin', 'AdminController@index')->name('admin');
    $router->get('admin/reparse/{tweet}', 'AdminController@reparse')->name('admin.reparse');
});

$router->get('tests', function () {
    return [
        do_street_compare('gral avilés'),
        do_street_compare('a. march'),
        do_street_compare('naranjos'),
        do_street_compare('tres creus')
    ];
});


function do_street_compare($text)
{
    $streets = collect(array_keys(config('streets.map')))->transform(function ($value) use ($text) {
        $find = ['avenida', 'dels', 'del', 'los', 'de', 'las', 'la', 'calle', 'carretera', 'paseo', 'camino'];

        $value = collect(explode('-', $value))->filter(function ($value) use ($find) {
            return !in_array($value, $find);
        })->toArray();

        $value = implode(' ', $value);
        similar_text($value, $text, $percent);

        $new = [];
        $new['text'] = $text;
        $new['street'] = $value;
        $new['percent'] = $percent;
        
        return $new;
    })->sortByDesc('percent');

    return $streets->values()->first();
}
