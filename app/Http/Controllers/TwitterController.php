<?php

namespace App\Http\Controllers;

use TwitterAPIExchange;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller
{


    public function timeline()
    {
        $user = Auth::user();
        $oauth = [
            'oauth_access_token'           => $user->provider_token,
            'oauth_access_token_secret'    => $user->provider_secret,
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
        ];

        $twitter = new TwitterAPIExchange($oauth);
        $params = '?count=40';
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $method = 'GET';
        $res = $twitter->setGetfield($params)
            ->buildOauth($url, $method)
            ->performRequest();
        return $res;
    }
}
