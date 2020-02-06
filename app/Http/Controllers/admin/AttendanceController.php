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
//    private $attendance = 0;
//    private $vacation = 0;
//    private $shift = 0;
//    private $holiday = 0;
//    private $diff = 0;
//    private $absenceTime = 0;
//    private $vacationTime = 0;
//    private $workingTime = 0;
//    private $overTime = 0;
//    private $holidayTime = 0;

    public function index()
    {
        $users = User::all();
        return view('admin.attendance.index',compact('users'));

    }

    public function getReport(Request $request)
    {
        $rawList = collect();
        $givenDate = Carbon::parse(DateFormat::toMiladi($request->date));
        $selectedDay = $givenDate->dayOfWeek;
        $currentDate = $givenDate->format('Y-m-d');
        $user = User::query()->find($request->user_id);


//        DB::listen(function ($sql) {
//            dump(vsprintf(str_replace('?', '%s', $sql->sql), $sql->bindings));
//        });

        /** @var Shift $userShift */
        $userShift = $user->getShift($currentDate);

        if (!$userShift)
            return back()->withErrors('لطفا شیفت کاری مربوط به این کاربر را انتخاب کنید');

        /** @var Day $dayOfShift */
        $dayOfShift = $userShift->getDayOfShift($currentDate, $selectedDay);
        dd($dayOfShift);
        if (!$dayOfShift)
            return back()->withErrors('لطفا روزهای کاری مربوط به این کاربر را انتخاب کنید');

//        dd($dayOfShift->toArray());
        dd($dayOfShift->dayShift);

        $workTimes = DayShift::query()->find($dayOfShift->pivot->id)->getWorkTimes($currentDate);


        $holidays = Attendance::getByCondition(new Holiday(), $currentDate);
        $userVacation = Attendance::getByCondition($user->demandVacations(), $currentDate);
        $userTimeSheet = $user->getTimeSheet($currentDate);
        $userTimeSheet = TimeSheet::isCouple($userTimeSheet);

        Attendance::addToList($workTimes, $rawList, 'شروع شیفت', 'پایان شیفت');
        Attendance::addToList($userVacation, $rawList, 'شروع مرخصی', 'پایان مرخصی');
        Attendance::addToList($holidays, $rawList, 'شروع تعطیلی', 'پایان تعطیلی');
        Attendance::addTimeSheetToList($userTimeSheet, $rawList);
        $rawList = Attendance::sortList($rawList);

        $reportList = Attendance::getReport($rawList);


        $sumList = Attendance::sumOfStatus($reportList);

        return view('admin.attendance.showReport', [
            'reportList'=>$reportList,
            'sumList'=>$sumList,
            'date'=>$request->date,
            'user'=>$user,
            'day'=>Day::find($selectedDay)->label
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


}
