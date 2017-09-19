@extends('layouts.admin')

@section('content')


    <div class="admin-grid">

        @foreach ($tweets as $tweet)

            <div class="fill-darker rounded m-05 p-1">
                <div class="admin-tweets">
                    <div class="tweet-content">
                        <span><span class="text-medium">{{ $tweet->date->diffForHumans() }}</span> <small class="text-small color-orange">{{ count($tweet->streets) }} {{ str_plural('street', count($tweet->streets)) }}</small></span>
                        <p class="text-small text-italic color-faded">{!! nl2br($tweet->text) !!}</p>
                    </div>
                    <div class="admin-actions text-small">
                        <a class="button button-red" href="{{ route('admin.reparse', $tweet) }}">Repharse Tweet</a>
                        <a class="button button-red">Exclude Tweet</a>
                    </div>
                </div>
                <div class="pl-05 pr-05 pt-05">
                    <ul class="street-list color-blue">
                        @foreach ($tweet->streets as $street)
                            <li>{{ $tweet->streets[$loop->index]->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

        @endforeach

        {{ $tweets->links() }}

    </div>

@endsection
