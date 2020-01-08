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
        $details = is_string($details) ? $details : json_encode($details);
        $fields =  ['event' => $event, 'details' => $details];
        $logEntry = self::make($fields);
        $logEntry->user_id = $user_id;
        $logEntry->save();
    }
}
