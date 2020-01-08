@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if ( Auth::user()->provider=='twitter')
                <div class="card-header">
                    <div class='titleWrapper'>
                        <span> Latest Tweets </span>
                        <a><i class="fa fa-refresh" aria-hidden="true" @click='loadTweets'></i></a>
                    </div>
                    <div v-cloak=true v-if='!error' class='filterWrapper float-md-right'>
                        <input v-model='filter' />
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <i v-show='filter' class="fa fa-times" aria-hidden="true" @click="filter=''"></i>
                    </div>
                </div>

                <div class="card-body">
                    <div v-cloak=true v-if='error' class='text-danger'> @{{ error }}</div>
                    <div v-for='tweet in tweets'>
                        <vtweet :tweet='tweet' :refreshTrigger='refreshCounter' />
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection