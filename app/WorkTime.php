<?php

namespace App;

use App\Helper\message;
use Illuminate\Database\Eloquent\Model;

class WorkTime extends Model
{
    protected $guarded = [];

    public function dayShift()
    {
        return $this->belongsTo(DayShift::class);
    }

    public static function getCurrentWorkTimes($shift,$day)
    {
        return  DayShift::query()->where([['shift_id', $shift->id], ['day_id', $day], ['to', null]])
            ->first()
            ->workTimes()
            ->where('to', null)
            ->get();
    }

    public  function removeTime()
    {
       $this->update([
            'to'=>now()
        ]);
        message::show('زمان های کاری با موفقیت حذف شدند');
    }

    public function days()
    {
        return $this->hasOneThrough(Day::class,DayShift::class, 'id', 'id');

    }



}
