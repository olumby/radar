<?php

namespace App\Http\Controllers;

use App\Support\Tweets\TweetReparser;
use App\Tweet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with('streets')->orderBy('date', 'DESC')->paginate(10);

        $tweets->transform(function ($value) {
            $value->text = preg_replace('/#(\S*)/', '<a class="tweet-hashtag" href="http://twitter.com/#!/search/$1">#$1</a>', $value->text);
            $value->text = preg_replace('/@(\S*)/', '<a class="tweet-mention" href="http://twitter.com/$1">@$1</a>', $value->text);
            $value->text = preg_replace('/(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/', '$1<a class="tweet-link" target="_blank"  href="$2">$2</a>$5', $value->text);

            return $value;
        });

        return view('admin.index', compact('tweets'));
    }

    public function reparse(Tweet $tweet)
    {

        (new TweetReparser($tweet))->reparse();

        // return $tweet->streets;

        return redirect(route('admin'));
    }
}
