<?php

namespace App\Http\Controllers\admin;

use App\Attendance;
use App\DayShift;
use App\Helper\message;
use App\Helpers\DateFormat;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\TimeSheet;
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
    private $holiday = 0;
    private $diff = 0;
    private $absenceTime = 0;
    private $vacationTime = 0;
    private $workingTime = 0;
    private $overTime = 0;
    private $holidayTime = 0;

    public function index()
    {
        $users = User::all();
        $reportList = [];
        return view('admin.attendance.index',compact('users'));

    }

    public function getReport(Request $request)
    {
        $users = User::all();
        $rawList = collect();
        $givenDate = Carbon::parse(DateFormat::toMiladi($request->date));
        $selectedDay = $givenDate->dayOfWeek;
        $currentDate = $givenDate->format('Y-m-d');
        $user = User::query()->find($request->user_id);


//        DB::listen(function ($sql) {
//            dump(vsprintf(str_replace('?', '%s', $sql->sql), $sql->bindings));
//        });

        $userShift = $user->getUserShift($currentDate);
        if (!$userShift)
            return back()->withErrors('لطفا شیفت کاری مربوط به این کاربر را انتخاب کنید');

        $shiftDays = Attendance::getDayOfShifts($userShift, $currentDate, $selectedDay);
        if (!$shiftDays)
            return back()->withErrors('لطفا روزهای کاری مربوط به این کاربر را انتخاب کنید');

        $workTimes = DayShift::getWorkTime($shiftDays,$currentDate);
        $holidays = Attendance::getByCondition(new Holiday(), $currentDate);
        $userVacation = Attendance::getByCondition($user->demandVacations(), $currentDate);
        $userTimeSheet = $user->getTimeSheet($currentDate);
        $userTimeSheet = TimeSheet::isCouple($userTimeSheet);

//        foreach ($workTimes as $time) {
//            $rawList->add([
//                ['time' => date('H:i', strtotime($time->start)), 'label' => 'شروع شیفت'],
//                ['time' => date('H:i', strtotime($time->end)), 'label' => 'پایان شیفت'],
//            ]);
//        }
//        foreach ($userVacation as $vacation) {
//            $rawList->add([
//                ['time' => date('H:i', strtotime($vacation->start)), 'label' => 'شروع مرخصی'],
//                ['time' => date('H:i', strtotime($vacation->end)), 'label' => 'پایان مرخصی'],
//            ]);
//        }
//        foreach ($holidays as $holiday) {
//            $rawList->add([
//                ['time' => date('H:i', strtotime($holiday->start)), 'label' => 'شروع تعطیلی'],
//                ['time' => date('H:i', strtotime($holiday->end)), 'label' => 'پایان تعطیلی'],
//            ]);
//        }
//        foreach ($userTimeSheet as $timeSheet) {
//            $rawList->add([
//                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'ورود'],
//                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'خروج'],
//            ]);
//        }
//        $rawList = array_values($rawList->flatten(1)->sortBy('time')->toArray());

//        for ($counter = 1; $counter < count($rawList); $counter++) {
//            $firstItem = $rawList[$counter - 1];
//            $secondItem = $rawList[$counter];
//            $this->diff = Carbon::parse($firstItem['time'])->diffInMinutes($secondItem['time']);
//            $finalList->add([
//                ['item1' => $firstItem['time'],
//                    'item2' => $secondItem['time'],
//                    'value' => $this->diff,
//                    'status' => $this->checkItems($firstItem, $secondItem)]
//            ]);
//
//        }
//        foreach ($finalList as $list) {
//            if ($list['status'] == 'کارکرد') {
//                $this->workingTime += $list['value'];
//            } elseif ($list['status'] == 'تعطیلی') {
//                $this->holidayTime += $list['value'];
//            } elseif ($list['status'] == 'غیبت') {
//                $this->absenceTime += $list['value'];
//            } elseif ($list['status'] == 'اضافه کاری') {
//                $this->overTime += $list['value'];
//            } elseif ($list['status'] == 'مرخصی') {
//                $this->vacationTime += $list['value'];
//            }
//
//        }
        //        $showCollect = collect([
//            'کارکرد'=>$this->workingTime,
//            'غیبت'=>$this->absenceTime,
//            'اضافه کاری'=>$this->overTime,
//            'تعطیلی' => $this->holidayTime,
//            'مرخصی '=>$this->vacationTime
//        ]);
        Attendance::addToList($workTimes, $rawList, 'شروع شیفت', 'پایان شیفت');
        Attendance::addToList($userVacation, $rawList, 'شروع مرخصی', 'پایان مرخصی');
        Attendance::addToList($holidays, $rawList, 'شروع تعطیلی', 'پایان تعطیلی');
        Attendance::addTimeSheetToList($userTimeSheet, $rawList);
        $rawList = Attendance::sortList($rawList);

        $reportList = Attendance::getReport($rawList);

        $sumList = Attendance::sumOfStatus($reportList);
        return view('admin.attendance.showReport', [
            'reportList'=>$reportList,
            'date'=>$request->date,
            'user'=>$user,
            'day'=>($givenDate)->englishDayOfWeek
        ]);

    }





    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {

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
