<?php

namespace App;

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
            dd('لطفا داده های حضور و غیاب را اصلاح کنید');
        else
            return $timeSheet->chunk(2);
    }


    public function scopeSearch($query, $data)
    {

        $query->whereHas('user', function ($query) use ($data) {
            $query->where('name', 'like', '%' . $data . '%')
                ->orwhere('family', 'like', '%' . $data . '%');
        });
        return $query;

    }

    public function scopeFilterByDate(Builder $query, $from, $to)
    {
        $query->whereBetween('finger_print_time', [$from, $to]);
    }


}
