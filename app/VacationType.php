<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacationType extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_vacation_amount');
    }

    public function vacationMeasurement()
    {
        return $this->belongsTo(VacationMeasurement::class,'vacation_measurement_id');
    }

    public function vacationPeriodTime()
    {
        return $this->belongsTo(VacationPeriodTime::class,'vacation_period_time_id');
    }


}


