<?php

namespace App;

use App\Helper\message;
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

//    public static function getDays($shift, $days)
//    {
//        return self::query()->where('shift_id', $shift->id)->whereIn('day_id', $days)->get();
//    }

    public static function getNullDays($shift, $days)
    {
        return self::query()->whereIn('day_id', $days)->where('to', null)->where('shift_id', $shift->id)->get();
    }

    public  function getWorkTimes($currentDate)
    {
        return $this->workTimes()
            ->where(function (Builder $query) use ($currentDate) {
                $query->whereRaw("DATE(work_times.from) <= '$currentDate' AND DATE(work_times.to) >= '$currentDate'")
                    ->orWhereRaw("DATE(work_times.from) <= '$currentDate' AND work_times.to is null");
            })->get();
    }

    public  function addWorkTime($start, $end)
    {
        for ($counter = 1; $counter < sizeof($start) + 1; $counter++) {
            $this->workTimes()->create([
                'start' => $start[$counter],
                'end' => $end[$counter]
            ]);
        }
        message::show('زمان های مورد نظر با موفقیت ثبت شدند');
    }
}
