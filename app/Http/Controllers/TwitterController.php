<?php


namespace App\Http\Controllers;

use Auth;
use App\AuditLog;
use TwitterAPIExchange;
use Illuminate\Http\Request;


/**
 *  Handles Twiter specific endpoints. 
 *  Uses TwitterAPIExchange to interact with Twitter API
 */
class TwitterController extends Controller
{

    /**
     * Returns logged-in user's Twitter timeline
     *
     * @return string
     */
    public function getTimeline(Request $request)
    {
        $user = Auth::user();

        $oauth = [
            'oauth_access_token' => $user->getProviderToken(),
            'oauth_access_token_secret' => $user->getProviderSecret(),
            'consumer_key' => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
        ];

        $twitter = new TwitterAPIExchange($oauth);
        $since_id = $request->input('since_id');
        $count = 30;
        $params = '?count=' . $count . ($since_id ? '&since_id=' . $since_id : '');
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $method = 'GET';

        $response = $twitter->setGetfield($params)
            ->buildOauth($url, $method)
            ->performRequest();

        $details = [
            'url' => $url,
            'params' => $params,
            'response' => json_decode($response)
        ];

        AuditLog::log(AuditLog::TWITTER_TIMELINE_RETRIEVED, $details);

        return $response;
    }
}
