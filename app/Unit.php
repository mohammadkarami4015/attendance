<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_unit', 'unit_id', 'shift_id')
            ->withPivot('from', 'to');
    }

    public function addShift($shift,$date)
    {
        $this->shifts()->attach($shift,['from'=>$date]);
        session()->flash('flash_message', 'شیفت مورد نظر ثبت شد');
    }

    public function getCurrentShift()
    {
        return $this->shifts()->whereNull('to')->first();
    }


}
