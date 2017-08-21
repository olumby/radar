<?php

$router->get('/', 'HomeController@index');

$router->get('dev', 'HomeController@dev');

$router->get('tweets', 'TweetController@index');
$router->get('tweet/{tweet}', 'TweetController@show');
