<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetTweetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('street_tweet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tweet_id')->unsigned();
            $table->integer('street_id')->unsigned();
            $table->dateTime('date');
            $table->string('match')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade');
            $table->foreign('street_id')->references('id')->on('streets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('street_tweet');
    }
}
