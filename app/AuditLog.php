<?php

namespace App;

/**
 *  usage: AuditLog::log($event,$details)
 */

use Auth;
use App\Traits\SavesModel;
use App\Traits\EntityReturnsAll;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="audit_logs")
 */
class AuditLog
{

    use SavesModel;
    use EntityReturnsAll;

    public const USER_OAUTH_AUTHENTICATION = 'user_authenticated_via_oauth';
    public const TWITTER_TIMELINE_RETRIEVED = 'twitter_timeline_retrieved';
    public const ERROR = 'ERROR';

    /**
     * @var int
     *
     * @ORM\Column(name="id",               type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * * @ORM\Column(type="string")
     */
    protected $event;

    /**
     * * @ORM\Column(type="string")
     */
    protected $details;

    /**
     * * @ORM\Column(type="integer")
     */
    protected $user_id;

    /**
     * * @ORM\Column(type="datetime")
     */
    protected $created_at;


    public function getEvent()
    {
        return $this->event;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function __construct($event, $details)
    {
        $user = Auth::user();
        $user_id = $user ? $user->getId() : null;
        $details = is_string($details) ? $details : json_encode($details);
        $this->event = $event;
        $this->details = $details;
        $this->user_id = $user_id;
    }

    public static function log($event, $details)
    {
        $auditLog = new self($event, $details);
        $auditLog->save();
    }
}
