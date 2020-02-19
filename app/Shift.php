<?php

namespace App;

use App\Helper\message;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;
    protected $casts = [
        'work_start' => 'time',
        'work_end' => 'time',
        'break_time_start' => 'time',
        'break_time_end' => 'time',
    ];
    protected $fillable = [
        'title',
        'over_time_before',
        'work_start',
        'work_end',
        'break_time_start',
        'break_time_end',
        'over_time_after'];


    public function days()
    {
        return $this->belongsToMany(Day::class, 'day_shift')->withPivot('id', 'from', 'to');
    }

    public function unit()
    {
        return $this->belongsToMany(Unit::class, 'shift_unit')
            ->withPivot('from', 'to');
    }

    public function workTimes()
    {
        return $this->hasManyThrough(WorkTime::class, DayShift::class, 'shift_id', 'day_shift_id');
    }


//    public function getPivotDay($days)
//    {
//        return $this->days()->wherePivotIn('day_id', $days)->get();
//    }
    public function dayShift($days)
    {
        return $this->days()->whereIn('day_id', $days)->get()->pluck('pivot.id');

    }

    public function getUsageDay()
    {
        return $this->days()->wherePivot('to', null)->get();
    }

    public function updateDays($days)
    {
        $removeDays = $this->getRemoveDays($days);
        $value = DayShift::getNullDays($this, $removeDays);
        foreach ($value as $day) {
            $day->to = now();
            $day->save();
        }

    }

    public function getRemoveDays($days)
    {
        return (($this->getUsageDay())->diff(Day::find($days)))->pluck('id')->toArray();
    }

    public function getAddedDays($days)
    {
        return Day::find($days)->diff($this->getUsageDay());
    }

    public function getDayOfShift($currentDate, $selectedDay)
    {
        return $this->days()
            ->where(function (Builder $query) use ($currentDate) {
                $query->whereRaw("DATE(day_shift.from) <= '$currentDate' AND DATE(day_shift.to) >= '$currentDate'")
                    ->orWhereRaw("DATE(day_shift.from) <= '$currentDate' AND day_shift.to is null");
            })->find($selectedDay);
    }




}
