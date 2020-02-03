<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_unit', 'unit_id', 'shift_id')
            ->withPivot('from', 'to');
    }

    public function addShift($shift)
    {
        $this->shifts()->attach($shift);
        session()->flash('flash_message', 'شیفت مورد نظر ثبت شد');
    }

    public function getCurrentShift()
    {
        return $this->shifts()->whereNull('to')->first();
    }


}
