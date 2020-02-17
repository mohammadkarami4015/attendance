<?php

namespace App;

use App\Helpers\DateFormat;
use App\Helpers\ManageList;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsTo(Unit::class, 'unit_id');
    }

//    public function getSpecialVacation(VacationType $vacationType)
//    {
//        return $this->vacationTypes()->find($vacationType->id)->pivot->amount;
//    }
//
//    public function setSpecialVacation(VacationType $leaveKind, int $amount)
//    {
//
//        return $this->vacationTypes()->attach($leaveKind->id, ['amount' => $amount]);
//    }
//
//    public function getTotalLeave(VacationType $leaveKind)
//    {
//        $monthsOfWorkingTime = Carbon::now()->diffInMonths(date('Y-m-d', strtotime($this->date_of_employment)));
//        return $monthsOfWorkingTime * $this->getSpecialVacation($leaveKind);
//    }
//
//    public function getLeaveBalance(VacationType $leaveKind)
//    {
//        return '';
//    }

    public function getReportBetweenDays(Carbon $startDate, Carbon $endDate, bool $isCollect = false)
    {
        $reportList = collect();
        while ($startDate <= $endDate) {
            $data = $this->getReport($startDate);
            if (!$isCollect) {
                $reportList->add($data);
            } else
                $reportList->add($data['sumOfStatus']);
            $startDate->addDay();
        }
        return $reportList;

    }

    public function getReport($date)
    {
        $rawList = collect();
        $list = new ManageList();
        $givenDate = $date;
        $selectedDay = $givenDate->dayOfWeek;
        $emptyValue = [
            'report' => [],
            'sumOfStatus' => [],
            'day' => Day::find($selectedDay)->label,
            'date' => clone $date,
        ];
        $currentDate = $givenDate->format('Y-m-d');
        $userShift = $this->getShift($currentDate);


        if (!$userShift)
            return array_merge(['message' => 'شیفت کاری در این تاریخ تعریف نشده'], $emptyValue);

        $dayOfShift = $userShift->getDayOfShift($currentDate, $selectedDay);

        if (!$dayOfShift)
            return array_merge(['message' => 'جزء روز کاری نمی باشد'], $emptyValue);

        $workTimes = DayShift::query()->find($dayOfShift->pivot->id)->getWorkTimes($currentDate);
        $holidays = Holiday::getHoliday($currentDate);
        $userVacation = $this->getVacation($currentDate);
        $userTimeSheet = $this->getTimeSheet($currentDate);

        if (TimeSheet::isCouple($userTimeSheet) == 1) {
            return array_merge(['message' => 'داده های ورود و خروج را بررسی کنید'], $emptyValue);
        } else
            $userTimeSheet = $userTimeSheet->chunk(2);


        $list->addTimeToList($workTimes, $rawList, 'start_shift', 'end_shift');
        $list->addTimeToList($userVacation, $rawList, 'start_vacation', 'end_vacation');
        $list->addTimeToList($holidays, $rawList, 'start_holiday', 'end_holiday');
        $list->addTimeSheetToList($userTimeSheet, $rawList);
        $sortedList = $list->sortList($rawList);

        $reportList = $list->getReport($sortedList);
        $sumList = $list->sumOfStatus($reportList);


        return [
            'report' => $reportList,
            'sumOfStatus' => $sumList,
            'day' => Day::find($selectedDay)->label,
            'date' => clone $date,
            'message' => ''
        ];

    }

    public function getShift($currentDate)
    {
        return $this->unit->shifts()
            ->where(function (Builder $query) use ($currentDate) {
                $query->whereRaw("DATE(shift_unit.from) <= '$currentDate' AND DATE(shift_unit.to) >= '$currentDate'")
                    ->orWhereRaw("DATE(shift_unit.from) <= '$currentDate' AND shift_unit.to is null");
            })->first();
    }

    public function getTimeSheet($currentDate)
    {
        return $this->timeSheets()->whereDate('finger_print_time', $currentDate)->get();
    }

    public function getVacation($currentDate)
    {
        return $this->demandVacations()->whereDate('start', '<=', $currentDate)
            ->whereDate('end', '>=', $currentDate)
            ->get();
    }

    public static function getReportForAnyUser($users,$start,$end)
    {
        $collectList=collect();
        foreach ($users as $value) {
            $user = User::query()->find((int)$value);
            $startDate = Carbon::parse(DateFormat::toMiladi($start));
            $endDate = Carbon::parse(DateFormat::toMiladi($end));
            $reportList = $user->getReportBetweenDays($startDate,$endDate,true);
            $collectList->add([$reportList->toArray(), $user]);
        }
        return $collectList;
    }


}
