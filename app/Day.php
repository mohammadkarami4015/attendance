<?php

namespace App;

use Facade\FlareClient\Time\Time;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{

    protected $guarded = [];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'day_shift')->withPivot('id', 'from', 'to');
    }

    public function workTimes()
    {
        return $this->hasManyThrough(WorkTime::class, DayShift::class, 'day_id', 'day_shift_id');
    }

//
//    public static function addShift($shift, $days)
//    {
//        foreach ($days as $day) {
//            $shift->days()->create([
//                'title' => $day
//            ]);
//        }
//        session()->flash('flash_message', 'شیفت مورد نظر با موفقیت ثبت شد');
//
//    }

    public function getWorkTimes()
    {
       return DayShift::find($this->pivot->id)->workTimes;
    }


}
