<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $guarded = [];

    public function dayShift()
    {
        return $this->belongsTo(DayShift::class);
    }

    public function day()
    {
        return $this->hasOneThrough(Day::class, DayShift::class, 'id', 'id');
    }


}
