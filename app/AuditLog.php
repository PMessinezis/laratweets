<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public const USER_OAUTH_AUTHENTICATION = 'user_authenticated_via_oauth';
    public const TWITTER_TIMELINE_RETRIEVED = 'twitter_timeline_retrieved';
    public const ERROR = 'ERROR';

    protected $fillable = ['event', 'details'];

    public static function log($event, $details)
    {
        $user = Auth::user();
        $user_id = $user ? $user->id : null;
        $fields =  ['event' => $event, 'details' => json_encode($details)];
        $l = self::make($fields);
        $l->user_id = $user_id;
        $l->save();
    }
}
