<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialVacation extends Model
{
    protected $table = 'user_vacation_amount';
    public $incrementing = true;

    public function users()
    {
        return $this->hasMany(User::class,'id','user_id');
    }

    public function vacationTypes()
    {
        return $this->hasMany(VacationType::class,'id','vacation_type_id');
    }
}
