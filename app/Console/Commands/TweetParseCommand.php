<?php

namespace App\Console\Commands;

use App\Tweet;
use App\Support\Tweets\TweetParser;
use Illuminate\Console\Command;

class TweetParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'radar:parse {twitter_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse a specified tweet.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id =  $this->argument('twitter_id');

        $tweetParser = new TweetParser(Tweet::where('twitter_id', $id)->first());

        $tweetParser->setCommand($this)->parse();
    }
}
