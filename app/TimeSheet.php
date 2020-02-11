<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
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


    public function scopeSearch($query, $data)
    {
        $query->whereHas('user', function ($query) use ($data) {
            $query->where('name', 'like', '%' . $data . '%')
                ->orwhere('family', 'like', '%' . $data . '%');
        });
        return $query;

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


}
