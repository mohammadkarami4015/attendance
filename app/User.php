<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function setAdmin()
    {
        $this->roles()->attach(Role::where('title', 'admin')->get()->first()->id);
    }

    public function isAdmin()
    {
        return $this->roles()->where('title', '=', 'admin')->exists();
    }


    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_user')
            ->withPivot('from', 'to');
    }


    public function timeSheets()
    {
        return $this->hasMany(TimeSheet::class);
    }

    public function demandVacations()
    {
        return $this->hasMany(DemandVacation::class);
    }

    public function vacationTypes()
    {
        return $this->belongsToMany(VacationType::class, 'user_vacation_amount')->withPivot('amount');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function getSpecialVacation(VacationType $vacationType)
    {
        return $this->vacationTypes()->find($vacationType->id)->pivot->amount;
    }

    public function setSpecialVacation(VacationType $leaveKind, int $amount){

        return $this->vacationTypes()->attach($leaveKind->id, ['amount'=>$amount]);
    }

    public function getTotalLeave(VacationType $leaveKind)
    {
        $monthsOfWorkingTime = Carbon::now()->diffInMonths(date('Y-m-d',strtotime($this->date_of_employment)));
        return $monthsOfWorkingTime * $this->getSpecialVacation($leaveKind);
    }

    public function getLeaveBalance(VacationType $leaveKind)
    {
        return '';
    }

}
