<?php

namespace App;

use App\Helper\message;
use App\Helpers\DateFormat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DayShift extends Model
{

    protected $guarded = [];
    protected $table = 'day_shift';

    public function workTimes()
    {
        return $this->hasMany(WorkTime::class, 'day_shift_id');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }


    public static function getNullDays($shift, $days)
    {
        return self::query()->whereIn('day_id', $days)->where('to', null)->where('shift_id', $shift->id)->get();
    }

    public function getWorkTimes($currentDate)
    {
        return $this->workTimes()
            ->where(function (Builder $query) use ($currentDate) {
                $query->whereRaw("DATE(work_times.from) <= '$currentDate' AND DATE(work_times.to) >= '$currentDate'")
                    ->orWhereRaw("DATE(work_times.from) <= '$currentDate' AND work_times.to is null");
            })->get();
    }

    public function addWorkTime($start, $end, $from)
    {
        for ($counter = 1; $counter < sizeof($start) + 1; $counter++) {
            $this->workTimes()->create([
                'start' => $start[$counter],
                'end' => $end[$counter],
                'from' => $from
            ]);
        }
        message::show('زمان های مورد نظر با موفقیت ثبت شدند');
    }
}
