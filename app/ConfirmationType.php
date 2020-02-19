<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfirmationType extends Model
{
    use SoftDeletes;
    protected $table = 'confirmation_types';

    protected $guarded = [];

}
