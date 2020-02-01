<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    protected $guarded = [];

    public function vacations()
    {
        return $this->hasMany(DemandVacation::class);

    }
}
