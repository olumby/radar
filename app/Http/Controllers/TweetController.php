<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with('streets')->orderBy('date', 'DESC')->paginate(14);

        return $tweets->toArray();
    }

    public function show($tweet)
    {
        $tweet = Tweet::with('streets')->findOrFail($tweet);

        return $tweet->toArray();
    }
}
