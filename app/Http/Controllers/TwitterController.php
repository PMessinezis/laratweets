<?php

namespace App\Http\Controllers;

use App\AuditLog;
use TwitterAPIExchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TwitterController extends Controller
{

    public function timeline(Request $request)
    {
        $user = Auth::user();

        $oauth = [
            'oauth_access_token'           => $user->provider_token,
            'oauth_access_token_secret'    => $user->provider_secret,
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
        ];

        $twitter = new TwitterAPIExchange($oauth);

        $count = 30;
        $params = '?count=' . $count;
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $method = 'GET';


        $res = $twitter->setGetfield($params)
            ->buildOauth($url, $method)
            ->performRequest();

        AuditLog::log(AuditLog::TWITTER_TIMELINE_RETRIEVED, $res);

        return $res;
    }
}
