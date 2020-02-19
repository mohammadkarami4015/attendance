<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeSheet extends Model
{
    use SoftDeletes;
    /*protected $casts = [
        'finger_print_time' => 'datetime',
    ];*/
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function operation()
    {
        return $this->belongsTo(OperationType::class);
    }

    public static function isCouple($timeSheet)
    {
        if ($timeSheet->count() % 2 == 1)
            return 1;

    }


    public function scopeFilterByDate(Builder $query, $from, $to, $user_id)
    {
        $query->where('user_id', $user_id)->whereBetween('finger_print_time', [$from, $to]);
    }

    public static function checkDouble()
    {
        return self::all()->groupBy(function ($query) {
            return Carbon::parse($query->finger_print_time)->format('Y-m-d');
        })->map->groupBy('user_id')->map->filter(function ($timeSheets) {
            return (count($timeSheets) % 2) != 0;
        })->filter(function ($item) {
            return count($item) > 0;
        })->sort();
    }

    public static function getFingerTime()
    {
        return self::all()->groupBy(function ($test) {
            return Carbon::parse($test->finger_print_time)->format('Y-m-d');
        })->keys();

    }


}
