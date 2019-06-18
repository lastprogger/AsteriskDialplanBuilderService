<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property int     $id
 * @property string  $company_id
 * @property string  $accountcode
 * @property string  $disallow
 * @property string  $allow
 * @property string  $allowoverlap
 * @property string  $allowsubscribe
 * @property string  $allowtransfer
 * @property string  $amaflags
 * @property string  $autoframing
 * @property string  $auth
 * @property string  $buggymwi
 * @property string  $callgroup
 * @property string  $callerid
 * @property string  $cid_number
 * @property string  $fullname
 * @property integer $call_limit
 * @property string  $callingpres
 * @property string  $canreinvite
 * @property string  $context
 * @property string  $defaultip
 * @property string  $dtmfmode
 * @property string  $fromuser
 * @property string  $fromdomain
 * @property string  $fullcontact
 * @property string  $g726nonstandard
 * @property string  $host
 * @property string  $insecure
 * @property string  $ipaddr
 * @property string  $language
 * @property string  $lastms
 * @property string  $mailbox
 * @property int     $maxcallbitrate
 * @property string  $mohsuggest
 * @property string  $md5secret
 * @property string  $musiconhold
 * @property string  $name
 * @property string  $nat
 * @property string  $outboundproxy
 * @property string  $deny
 * @property string  $permit
 * @property string  $pickupgroup
 * @property string  $port
 * @property string  $progressinband
 * @property string  $promiscredir
 * @property string  $qualify
 * @property string  $regexten
 * @property int     $regseconds
 * @property string  $rfc2833compensate
 * @property string  $rtptimeout
 * @property string  $rtpholdtimeout
 * @property string  $secret
 * @property string  $sendrpid
 * @property string  $setvar
 * @property string  $subscribecontext$
 * @property string  $subscribemwi
 * @property string  $t38pt_udptl
 * @property string  $trustrpid
 * @property string  $type
 * @property string  $useclientcode
 * @property string  $username
 * @property string  $usereqphone
 * @property string  $videosupport
 * @property string  $vmexten
 * @property string  $callbackextension
 * @property string  $useragent
 * @property string  $regserver
 * @property string  $phone_number
 * @property string  $phone_number_id
 * @property Carbon $created_at
 */
class SipUser extends Model
{
    protected $table = 'sip_users';

    public $timestamps = false;

    protected $dates = ['created_at'];

}
