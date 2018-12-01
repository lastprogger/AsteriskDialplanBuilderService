<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property int  $id
 * @property string  $context
 * @property string  $exten
 * @property string  $priority
 * @property string  $app
 * @property string  $appdata
 * @property string  $company_id
 * @property string  $pbx_scheme_id
 * @property Carbon  $deleted_at
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 */
class Extension extends Model
{
    use SoftDeletes;

    protected $table      = 'extensions';
    public    $timestamps = false;

    protected $dates = ['created_at', 'deleted_at'];

}
