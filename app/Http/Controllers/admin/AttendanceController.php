<?php

namespace App\Http\Controllers\admin;

use App\DayShift;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Unit;
use App\User;
use App\WorkTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    private $attendance = 0;
    private $vacation = 0;
    private $shift = 0;
    private $holiday = 0 ;
    private $diff = 0 ;
    private $absenceTime = 0 ;
    private $vacationTime = 0 ;
    private $workingTime = 0 ;
    private $overTime = 0 ;
    private $holidayTime = 0 ;

    public function index()
    {
        $list = collect();
        $currentDate = Carbon::parse('2020-02-03');
        $selectedDay = $currentDate->dayOfWeek;

        $user = User::query()->find(1);

//        DB::listen(function ($sql) {
//            dump(vsprintf(str_replace('?', '%s', $sql->sql), $sql->bindings));
//        });

        $userShift = $user->unit->shifts()
            ->where(function (Builder $query) use ($currentDate) {
                $query->where([['from', '<=', $currentDate], ['to', '>=', $currentDate]])
                    ->orWhere([['from', '<=', $currentDate], ['to', null]]);
            })->first();


        $days = $userShift->days()
            ->where(function (Builder $query) use ($currentDate) {
            $query->where([['from', '<=', $currentDate], ['to', '>=', $currentDate]])
                ->orWhere([['from', '<=', $currentDate], ['to', null]]);
        })->find($selectedDay);

       $workTimes = DayShift::find($days->pivot->id)->workTimes;

        $holidays = Holiday::query()
            ->whereDate('start','<=',$currentDate)
            ->whereDate('end','>=',$currentDate)
            ->get();

        $userTimeSheet = $user->timeSheets()->whereDate('finger_print_time', $currentDate)->get()->chunk(2);

        $userVacation = $user->demandVacations()->whereDate('start', '<=', $currentDate)->whereDate('end', '>=', $currentDate)->get();

        foreach ($workTimes as $time) {
            $list->add([
                ['time' => date('H:i', strtotime($time->start)), 'label' => 'شروع شیفت'],
                ['time' => date('H:i', strtotime($time->end)), 'label' => 'پایان شیفت'],
            ]);
        }

        foreach ($userVacation as $vacation) {
            $list->add([
                ['time' => date('H:i', strtotime($vacation->start)), 'label' => 'شروع مرخصی'],
                ['time' => date('H:i', strtotime($vacation->end)), 'label' => 'پایان مرخصی'],
            ]);
        }

        foreach ($holidays as $holiday) {
            $list->add([
                ['time' => date('H:i', strtotime($holiday->start)), 'label' => 'شروع تعطیلی'],
                ['time' => date('H:i', strtotime($holiday->end)), 'label' => 'پایان تعطیلی'],
            ]);
        }

        foreach ($userTimeSheet as $timeSheet) {
            $list->add([
                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'ورود'],
                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'خروج'],
            ]);
        }


        $list = array_values($list->flatten(1)->sortBy('time')->toArray());



        $finalList = collect();

        for ($counter = 1; $counter < count($list); $counter++) {
            $firstItem = $list[$counter - 1];
            $secondItem = $list[$counter];
            $this->diff = Carbon::parse($firstItem['time'])->diffInMinutes($secondItem['time']);
            $finalList->add([
                ['item1' => $firstItem['time'], 'item2' => $secondItem['time'], 'value' => $this->diff, 'status' => $this->checkItems($firstItem, $secondItem)]
            ]);

        }

        dump($finalList->flatten(1));
        foreach ($finalList->flatten(1) as $list) {
            if ($list['status'] == 'کارکرد') {
                $this->workingTime += $list['value'];
            } elseif ($list['status'] == 'تعطیلی') {
                $this->holidayTime += $list['value'];
            } elseif ($list['status'] == 'غیبت') {
                $this->absenceTime += $list['value'];
            }elseif ($list['status'] == 'اضافه کاری'){
                $this->overTime += $list['value'];
            }elseif ($list['status'] == 'مرخصی'){
                $this->vacationTime += $list['value'];
            }

        }
        dd(' کارکرد:' . $this->workingTime, ' غیبت :' . $this->absenceTime, ' مرخصی :' . $this->vacationTime, ' اضافه کاری :' . $this->overTime, '  تعطیلی :' . $this->holidayTime );








    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function checkItems(array $firstItem, array $secondItem)
    {
        if ($firstItem['label'] == 'ورود') {
            $this->attendance = 1;
        } elseif ($firstItem['label'] == 'خروج') {
            $this->attendance = 0;
        }

        if ($firstItem['label'] == 'شروع شیفت') {
            $this->shift = 1;
        } elseif ($firstItem['label'] == 'پایان شیفت') {
            $this->shift = 0;
        }

        if ($firstItem['label'] == 'شروع مرخصی') {
            $this->vacation = 1;
        } elseif ($firstItem['label'] == 'پایان مرخصی') {
            $this->vacation = 0;
        }

        if ($firstItem['label'] == 'شروع تعطیلی') {
            $this->holiday = 1;
        } elseif ($firstItem['label'] == 'پایان تعطیلی') {
            $this->holiday = 0;
        }

        if ($this->attendance == 0 && $this->shift == 0) {
            return 'invalid';
        }

        if ($this->attendance == 0 && $this->shift == 1) {

            if ($this->vacation == 0 && $this->holiday == 0) {
                return 'غیبت';
            }

            if ($this->vacation == 1 && $this->holiday == 0) {
                return 'مرخصی';
            }

            if ($this->holiday == 1) {
                return 'تعطیلی';
            }
        }

        if ($this->attendance == 1 && $this->shift == 0) {
            return 'اضافه کاری';
        }

        if ($this->attendance == 1 && $this->shift == 1) {
            if ($this->holiday == 1) {
                return 'اضافه کاری';
            } else {
                return 'کارکرد';
            }
        }
    }
}
