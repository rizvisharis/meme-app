<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class BaseModel extends Eloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
