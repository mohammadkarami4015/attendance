<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Stmt\DeclareDeclare;

class Unit extends Model
{
    protected $guarded=[];

    public function shifts()
    {
        return $this->belongsToMany(Shift::class,'shift_unit')
            ->withPivot('from', 'to');
    }

    public function addShift($shift)
    {
       $this->shifts()->attach($shift);
        session()->flash('flash_message', 'شیفت مورد نظر ثبت شد');
    }

    public  function getCurrentShift()
    {
        return $this->shifts()->whereNull('to')->first();
    }



}
