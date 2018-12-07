<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property int    $id
 * @property string $pbx_scheme_id
 * @property string $start_exten
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class PbxScheme extends Model
{
    use SoftDeletes;

    protected $table = 'pbx_schemes';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}
