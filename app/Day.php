<?php

namespace App;

use App\Helper\message;
use Facade\FlareClient\Time\Time;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{

    protected $guarded = [];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'day_shift')->withPivot('id', 'from', 'to');
    }

    public function dayShift()
    {
        return $this->hasMany(DayShift::class);
    }

    public function workTimes()
    {
        return $this->hasManyThrough(WorkTime::class, DayShift::class, 'day_id', 'day_shift_id');
    }

    public function getWorkTimes()
    {
       return DayShift::query()->find($this->pivot->id)->workTimes()->where('to',null)->get();
    }



}
