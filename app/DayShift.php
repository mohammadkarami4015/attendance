<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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



    public static function getWorkTime($day, $currentDate)
    {
        return self::find($day->pivot->id)->workTimes()
            ->where(function (Builder $query) use ($currentDate) {
                $query->whereRaw("DATE(work_times.from) <= '$currentDate' AND DATE(work_times.to) >= '$currentDate'")
                    ->orWhereRaw("DATE(work_times.from) <= '$currentDate' AND work_times.to is null");
            })->get();
    }
}
