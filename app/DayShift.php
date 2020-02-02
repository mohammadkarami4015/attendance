<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayShift extends Model
{
    protected $guarded = [];
    protected $table = 'day_shift';

    public function workTimes()
    {
        return $this->hasMany(WorkTime::class, 'day_shift_id');
    }

    public static function getDays($shift, $days)
    {
        return self::query()->where('shift_id', $shift->id)->whereIn('day_id', $days)->get();
    }

    public static function getNullDays($shift, $days)
    {
        return self::query()->whereIn('day_id', $days)->where('to', null)->where('shift_id', $shift->id)->get();
    }
}
