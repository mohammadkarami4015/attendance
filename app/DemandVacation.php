<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Psy\Test\ConfigurationTest;

class DemandVacation extends Model
{
    protected $casts =[
        'start'=>'time',
        'end'=>'time'
    ];
    protected $guarded = [];

//    public function operation()
//    {
//     return $this->belongsTo(OperationType::class);
//    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacationType()
    {
        return $this->belongsTo(VacationType::class,'vacation_type_id');
    }

    public function hourlyDaily()
    {
        return $this->belongsTo(HourlyDaily::class,'hourly_daily_id');
    }

    public function justificationType()
    {
        return $this->belongsTo(JustificationType::class,'justification_type_id');
    }

    public function confirmationType()
    {
        return $this->belongsTo(ConfirmationType::class,'confirmation_type_id');
    }




}
