<?php

namespace App;

use GuzzleHttp\Client;
use TwitterAPIExchange;
use GuzzleHttp\HandlerStack;

use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'provider_token', 'provider_secret'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function tweets()
    {



        $oauth = [
            'oauth_access_token'           => $this->provider_token,
            'oauth_access_token_secret'    => $this->provider_secret,
            'consumer_key'    => config('services.twitter.client_id'),
            'consumer_secret' => config('services.twitter.client_secret'),
        ];
        $params = '?count=40';
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $method = 'GET';
        $twitter = new TwitterAPIExchange($oauth);
        $res = $twitter->setGetfield($params)->buildOauth($url, $method)
            ->performRequest();
        return $res;
    }
}
