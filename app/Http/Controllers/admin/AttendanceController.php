<?php

namespace App\Http\Controllers\admin;

use App\Attendance;
use App\Day;
use App\DayShift;
use App\Helper\message;
use App\Helpers\DateFormat;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Shift;
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


    public function index()
    {
        $users = User::all();
        return view('admin.attendance.index', compact('users'));

    }

    public function getReport(Request $request)
    {
        $user = User::query()->find($request->user_id);
        $collectList = collect();
        $startDate = Carbon::parse(DateFormat::toMiladi($request->start_date));
        $endDate = $date = Carbon::parse(DateFormat::toMiladi($request->end_date));

        while ($startDate <= $endDate) {
            $collectList->add($user->getReport($startDate));
            $startDate->addDay();
        }



        return view('admin.attendance.showReport', [
            'collectList' => $collectList,
            'user' => User::find($request->user_id),
        ]);


    }

//    public function getReport(Request $request)
//    {
//        $user = User::query()->find($request->user_id);
//        $date = Carbon::parse(DateFormat::toMiladi($request->date));
////        $report = Attendance::getReportt($date, $request->user_id);
//        $reportList = $user->getReport($date);
//
//
//
////        $rawList = collect();
////        $givenDate = Carbon::parse(DateFormat::toMiladi($request->date));
////        $selectedDay = $givenDate->dayOfWeek;
////        $currentDate = $givenDate->format('Y-m-d');
////        $user = User::query()->find($request->user_id);
////
////        /** @var Shift $userShift */
////        $userShift = $user->getShift($currentDate);
////
////        if (!$userShift)
////            return back()->withErrors('لطفا شیفت کاری مربوط به این کاربر را انتخاب کنید');
////
////        /** @var Day $dayOfShift */
////        $dayOfShift = $userShift->getDayOfShift($currentDate, $selectedDay);
////
////
////        if (!$dayOfShift)
////            return back()->withErrors('لطفا روزهای کاری مربوط به این کاربر را انتخاب کنید');
////
////        $workTimes = DayShift::query()->find($dayOfShift->pivot->id)->getWorkTimes($currentDate);
////
////        $holidays = Attendance::getByCondition(new Holiday(), $currentDate);
////        $userVacation = Attendance::getByCondition($user->demandVacations(), $currentDate);
////        $userTimeSheet = $user->getTimeSheet($currentDate);
////        $userTimeSheet = TimeSheet::isCouple($userTimeSheet);
////
////        Attendance::addToList($workTimes, $rawList, 'شروع شیفت', 'پایان شیفت');
////        Attendance::addToList($userVacation, $rawList, 'شروع مرخصی', 'پایان مرخصی');
////        Attendance::addToList($holidays, $rawList, 'شروع تعطیلی', 'پایان تعطیلی');
////        Attendance::addTimeSheetToList($userTimeSheet, $rawList);
////
////        $rawList = Attendance::sortList($rawList);
////
////        $reportList = Attendance::getReport($rawList);
////
////        $sumList = Attendance::sumOfStatus($reportList);
//
////        return view('admin.attendance.showReport', [
////            'reportList' => $report['reportList'],
////            'sumList' => $report['sumList'],
////            'date' => $request->date,
////            'user' => User::find($request->user_id),
////            'day' => $report['day']
////        ]);
//
//
//        return view('admin.attendance.showReport', [
//            'reportList' => $reportList,
//            'user' => User::find($request->user_id),
//        ]);
//
//    }


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


}
