<?php

namespace App\Domain\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;


/**
 * @property int    $id
 * @property string|null $pbx_scheme_id
 * @property string $exten
 * @property bool $free
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ExtensionsStorage extends Model
{
    use SoftDeletes;

    protected $table = 'extensions_storage';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

}
