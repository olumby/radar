<?php

namespace App\Http\Controllers;

use App\Tweet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tweets = Tweet::with('streets')->orderBy('date', 'DESC')->get();

        $streets = \App\Street::all();

        return view('home', compact('tweets', 'streets'));
    }
}
