<?php

namespace Tests\Feature;

use App\Day;
use App\DemandVacation;
use App\Holiday;
use App\Shift;
use App\TimeSheet;
use App\User;
use App\WorkTime;
use Carbon\Carbon;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{

    /**
     * @var int
     */
    private $attendanceStatus = 0;
    private $vacationStatus = 0;
    private $shiftStatus = 0;
    private $holidayStatus = 0;
    private $diff = 0;
    private $workingTime = 0;
    private $hurryTime = 0;
    private $absenceTime = 0;
    private $vacationTime = 0;
    /**
     * @var int
     */


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        $currentDate = Carbon::parse('2020-01-01');
        $selectedDay = $currentDate->dayOfWeek;
        $dayShift = Day::find($selectedDay)->shifts;

        // find userShift and calculate start , end of work and breakTime
        $user = User::find(1);
        $userShift = $user->shifts->intersect($dayShift)->first();
        if ($userShift->break_time_start == null) {
            $startBreak = Carbon::parse($userShift->work_end);
            $endBreak = Carbon::parse($userShift->work_end);
        } else {
            $startBreak = Carbon::parse($userShift->break_time_start);
            $endBreak = Carbon::parse($userShift->break_time_end);
        }
        $startWork = Carbon::parse($userShift->work_start);
        $endWork = Carbon::parse($userShift->work_end);
        //end of userShift calculate

//calculate holiday in current time
        $holiday = Holiday::query()->whereDate('start_time', $currentDate)->first();
        $startHoliday = Carbon::parse(Carbon::parse($holiday->start_time)->format('H:i'));
        $endHoliday = Carbon::parse(Carbon::parse($holiday->end_time)->format('H:i'));

        if ($holiday != null) {
            $holidayTime = $startHoliday->diffInMinutes($endHoliday);
            if ($startHoliday < $startBreak && $endHoliday > $endBreak)
                $holidayTime -= $endBreak->diffInMinutes($startBreak);
        } else
            $holidayTime = 0;
//end of holiday
        //get user timeSheet
        $userTimeSheet = $user->timeSheets()->whereDate('finger_print_time', $currentDate)->get();
        $enEx = ($userTimeSheet->chunk(2));

// calculate users vacation time in current date
        $leave = DemandVacation::query()
            ->whereDate('start', '<=', $currentDate)->whereDate('end', '>=', $currentDate)
            ->first();
        $startLeave = Carbon::parse(Carbon::parse($leave->start)->format('H:i'));
        $endLeave = Carbon::parse(Carbon::parse($leave->end)->format('H:i'));

        if ($leave != null) {
            if ($leave->is_daily) {
                $leaveTime = 480;
            } else {
                $leaveTime = $startLeave->diffInMinutes($endLeave);
                if ($startLeave < $startBreak && $endLeave > $endBreak)
                    $leaveTime -= $endBreak->diffInMinutes($startBreak);
            }
        } else
            $leaveTime = 0;


//end of calculate users vacation


        $workingTime = 0;

        $fullTime = (($startWork)->diffInMinutes($startBreak)) + ($endBreak)->diffInMinutes($endWork);

        foreach ($enEx as $value) {
            $en = Carbon::parse((Carbon::parse($value->pluck('finger_print_time')[0])->format('H:i')));
            $ex = Carbon::parse((Carbon::parse($value->pluck('finger_print_time')[1])->format('H:i')));

            if ($en < $startBreak) {
                if ($en < $startWork)
                    $en = $startWork;

                if ($ex > $startBreak)
                    $ex = $startBreak;
                $workingTime = $en->diffInMinutes($ex);
                $fullTime -= $workingTime;
            } else {
                if ($en < $endBreak)
                    $en = $endBreak;

                if ($ex > $endWork)
                    $ex = $endWork;

                $workingTime = $en->diffInMinutes($ex);
                $fullTime -= $workingTime;
            }
        }


        $missingTime = $fullTime - $leaveTime - $holidayTime;


    }


    public function testBasic1()
    {


        $currentDate = Carbon::parse('2020-01-01');
        $selectedDay = $currentDate->dayOfWeek;
        $dayShift = Day::find($selectedDay)->shifts;

        // find userShift and calculate start , end of work and breakTime
        $user = User::find(1);
        $userShift = $user->shifts->intersect($dayShift)->first();
        if ($userShift->break_time_start == null) {
            $startBreak = Carbon::parse($userShift->work_end);
            $endBreak = Carbon::parse($userShift->work_end);
        } else {
            $startBreak = Carbon::parse($userShift->break_time_start);
            $endBreak = Carbon::parse($userShift->break_time_end);
        }
        $startWork = Carbon::parse($userShift->work_start);
        $endWork = Carbon::parse($userShift->work_end);
        //end of userShift calculate

//calculate  holiday time in one day
        $holidays = Holiday::query()->whereDate('start_time', $currentDate)->get();
        $holidayTime = 0;
        if ($holidays != null) {
            foreach ($holidays as $value) {
                $startHoliday = Carbon::parse(Carbon::parse($value->start_time)->format('H:i'));
                $endHoliday = Carbon::parse(Carbon::parse($value->end_time)->format('H:i'));
                $holidayTime += $startHoliday->diffInMinutes($endHoliday);
                if ($startHoliday < $startBreak && $endHoliday > $endBreak)
                    $holidayTime -= $endBreak->diffInMinutes($startBreak);
            }
        }


//end of holiday
        //get user timeSheet
        $userTimeSheet = $user->timeSheets()->whereDate('finger_print_time', $currentDate)->get();
        $enEx = ($userTimeSheet->chunk(2));


// calculate users vacation time in current date
        $leave = DemandVacation::query()
            ->whereDate('start', '<=', $currentDate)->whereDate('end', '>=', $currentDate)
            ->get();

        $leaveTime = 0;
        if ($leave->count() != 0) {
            if ($leave->first()->is_daily)
                $leaveTime = 480;
            else
                foreach ($leave as $value) {
                    $start = Carbon::parse(Carbon::parse($value->start)->format('H:i'));
                    $end = Carbon::parse(Carbon::parse($value->end)->format('H:i'));
                    $leaveTime += $start->diffInMinutes($end);
                    if ($start < $startBreak && $end > $endBreak)
                        $leaveTime -= $endBreak->diffInMinutes($startBreak);
                }
        }
//        $leave = $leave->first();
//
//
//        $compare = $userTimeSheet->map(function ($query) use ($leave, $endBreak, $startBreak) {
//            $test = ([$query->finger_print_time->diffInMinutes($leave->start),$query->finger_print_time->diffInMinutes($leave->end)]);
//
////            if ((Carbon::parse(Carbon::parse($leave->start)->format('H:i')) == $endBreak )||
////                (Carbon::parse(Carbon::parse($leave->end)->format('H:i')) == $startBreak) ||
////                 (  (Carbon::parse(Carbon::parse($leave->start)->format('H:i'))) < $startBreak && $startBreak < (Carbon::parse(Carbon::parse($leave->end)->format('H:i'))))) {
////                $test -= 120;
////            }
//            dump ($test);
//        });
//        dd($compare);

//        $var = $compare->filter(function ($value) {
//            return $value < 20;
//        });
//
//        if ($var->count() < 1)
//            dd('please check vacation and timeSheet');


//end of calculate users vacation


        $workingTime = 0;


        $fullTime = (($startWork)->diffInMinutes($startBreak)) + ($endBreak)->diffInMinutes($endWork);

        foreach ($enEx as $value) {
            $en = Carbon::parse((Carbon::parse($value->pluck('finger_print_time')[0])->format('H:i')));
            $ex = Carbon::parse((Carbon::parse($value->pluck('finger_print_time')[1])->format('H:i')));

            if ($en < $startBreak) {
                if ($en < $startWork)
                    $en = $startWork;

                if ($ex > $startBreak)
                    $ex = $startBreak;
                $workingTime = $en->diffInMinutes($ex);
                $fullTime -= $workingTime;
            } else {
                if ($en < $endBreak)
                    $en = $endBreak;

                if ($ex > $endWork)
                    $ex = $endWork;

                $workingTime = $en->diffInMinutes($ex);
                $fullTime -= $workingTime;
            }
        }
        dd($fullTime);

        $missingTime = $fullTime - $leaveTime - $holidayTime;
        dd($missingTime);


    }

    public function testCollection()
    {

        $timeSheets = collect([
            //['time' => date('H:i', strtotime('6:00')), 'label' => 'n'],
            // ['time' => date('H:i', strtotime('7:00')), 'label' => 'x'],
            //['time' => date('H:i', strtotime('7:50')), 'label' => 'n'],
            // ['time' => date('H:i', strtotime('9:35')), 'label' => 'x'],
            ['time' => date('H:i', strtotime('10:29')), 'label' => 'n'],
            ['time' => date('H:i', strtotime('12:10')), 'label' => 'x'],
            ['time' => date('H:i', strtotime('13:55')), 'label' => 'n'],
            ['time' => date('H:i', strtotime('15:00')), 'label' => 'x'],
            ['time' => date('H:i', strtotime('16:00')), 'label' => 'n'],
            ['time' => date('H:i', strtotime('18:10')), 'label' => 'x'],
        ]);

        $shifts = collect([
            ['time' => date('H:i', strtotime('8:00')), 'label' => 'ws'],
            ['time' => date('H:i', strtotime('12:00')), 'label' => 'we'],
            ['time' => date('H:i', strtotime('14:00')), 'label' => 'ws'],
            ['time' => date('H:i', strtotime('18:00')), 'label' => 'we'],
        ]);

        $vacations = collect([
            ['time' => date('H:i', strtotime('9:30')), 'label' => 'vs'],
            ['time' => date('H:i', strtotime('10:30')), 'label' => 've'],
        ]);

        $list = $timeSheets->merge($shifts->merge($vacations));

        dd($list);
        $list2 = $list->sortBy('time');
        $sortedList = array_values($list2->toArray());
        dd($sortedList);
        //dump($sortedList);

        for ($counter = 1; $counter < count($sortedList); $counter++) {
            $firstItem = $sortedList[$counter - 1];
            $secondItem = $sortedList[$counter];
            dump($firstItem['label']);
            dump($secondItem['label']);
            $status = $this->checkItems($firstItem, $secondItem);
            dump($firstItem['time'] . ' ' . $status . ' ' . $secondItem['time']);
        }
    }


    public function testGetData()
    {
        $currentDate = Carbon::parse('2020-01-06');
        $selectedDay = $currentDate->dayOfWeek;
        $list = collect();

        $user = User::find(1);


        $workTimes = $user->shifts->first()->days->find($selectedDay)->workTimes;

        $userTimeSheet = $user->timeSheets()->whereDate('finger_print_time', $currentDate)->get()->chunk(2);

        $userVacation = $user->vacations()->whereDate('start', '<=', $currentDate)->whereDate('end', '>=', $currentDate)->get();

        foreach ($userVacation as $vacation) {
            $list->add([
                ['time' => date('H:i', strtotime($vacation->start)), 'label' => 'vs'],
                ['time' => date('H:i', strtotime($vacation->end)), 'label' => 've'],
            ]);
        }

        foreach ($userTimeSheet as $timeSheet) {
            $list->add([
                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'n'],
                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'x'],
            ]);
        }
        foreach ($workTimes as $time) {
            $list->add([
                ['time' => date('H:i', strtotime($time->work_start)), 'label' => 'ws'],
                ['time' => date('H:i', strtotime($time->work_end)), 'label' => 'we'],
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
            if ($list['status'] == 'workingTime') {
                $this->workingTime += $list['value'];
            } elseif ($list['status'] == 'hurry') {
                $this->hurryTime += $list['value'];
            } elseif ($list['status'] == 'vacation') {
                $this->vacationTime += $list['value'];
            } elseif ($list['status'] == 'absence') {
                $this->absenceTime += $list['value'];
            }
        }
        dd(' کارکرد:' . $this->workingTime, ' تعجیل :' . $this->hurryTime, ' غیبت :' . $this->absenceTime, ' مرخصی :' . $this->vacationTime);


    }

    public function checkItems(array $firstItem, array $secondItem)
    {
        if ($firstItem['label'] == 'n') {
            $this->attendanceStatus = 1;
        } elseif ($firstItem['label'] == 'x') {
            $this->attendanceStatus = 0;
        }

        if ($firstItem['label'] == 'ws') {
            $this->shiftStatus = 1;
        } elseif ($firstItem['label'] == 'we') {
            $this->shiftStatus = 0;
        }

        if ($firstItem['label'] == 'vs') {
            $this->vacationStatus = 1;
        } elseif ($firstItem['label'] == 've') {
            $this->vacationStatus = 0;
        }

        if ($firstItem['label'] == 'hs') {

            $this->vacationStatus = 1;
        } elseif ($firstItem['label'] == 'he') {
            $this->vacationStatus = 0;

            $this->holidayStatus = 1;
        } elseif ($firstItem['label'] == 'he') {
            $this->holidayStatus = 0;
        }

        if ($firstItem['label'] == 'n') {

            switch ($secondItem['label']) {
                case "he":
                    return 'overTimeHoliday';
                case "ws":
                    return 'overTimeBefore';
                case "x":
                    if ($this->shiftStatus == 1) {
                        return 'workingTime';
                    } elseif ($this->shiftStatus == 0) {
                        return 'overtime';
                    }
                    break;
                default:
                    return 'workingTime';
            }
        }

        if ($firstItem['label'] == 'x') {

            switch ($secondItem['label']) {
                case "ve":
                    return 'vacation';
                case "ws":
                    return 'invalid';
                case "he":
                    return 'holiday';
                case "we":
                    return 'hurry';
                case "n":
                    if ($this->holidayStatus == 1) {
                        return 'holiday';
                    } elseif ($this->vacationStatus == 1) {
                        return 'vacation';
                    } elseif ($this->shiftStatus == 1) {
                        return 'absence';
                    } else {
                        return 'invalid';
                    }
                    break;
                default:
                    return 'absence';
            }
        }

        if ($secondItem['label'] == 'n') {

            switch ($firstItem['label']) {
                case "ws":
                    return 'delay';
                case "we":
                    return 'invalid';
                case "vs":
                    return 'vacation';
                case "hs":
                    return 'holiday';
                case "ve":
                case "he":
                    if ($this->shiftStatus == 1) return 'absence';
                    break;
            }
        }

        if ($secondItem['label'] == 'x') {

            switch ($firstItem['label']) {
                case "we":
                    return "overTimeAfter";
                case "hs":
                    return 'overTimeHoliday';
                case "he":

                    if ($this->shiftStatus == 1) {

                        return 'workingTime';
                    } else {
                        return 'overtTime';
                    }
                    break;
                default:
                    return 'workingTime';
            }

        }

        if ($firstItem['label'] == 'hs' && $secondItem['label'] == 'he') {
            if ($this->attendanceStatus == 0) {
                return 'holiday';
            } else {
                return 'overTimeHoliday';
            }
        }


        if ($firstItem['label'] == 'vs' && $secondItem['label'] == 've') {
            if ($this->attendanceStatus == 1) {

                return 'workingTime';
            } else {
                return 'vacation';
            }
        }


        if ($firstItem['label'] == 'ws') {
            switch ($secondItem['label']) {
                case "we":
                case "hs":
                case "vs":
                    if ($this->attendanceStatus == 1) {
                        return 'workingTime';
                    } else {
                        return 'absence';
                    }
            }
        }

        if ($secondItem['label'] == 'we') {
            switch ($firstItem['label']) {
                case "he":
                case "ve":
                    if ($this->attendanceStatus == 1) {
                        return 'workingTime';
                    } else {
                        return 'absence';
                    }
            }
        }
    }

    public function testGetData1()
    {
        $currentDate = Carbon::parse('2020-01-06');
        $selectedDay = $currentDate->dayOfWeek;
        $list = collect();

        $user = User::find(1);
        $userShift = $user->unit->shifts()->wherePivot('to',null)->first();
        $var = $userShift->days->find($selectedDay)->pivot;

        dd(WorkTime::query()->where('day_shift_id',$var->id)->get()->toArray());

        $workTimes = $user->shifts->first()->days->find($selectedDay)->workTimes;

        $userTimeSheet = $user->timeSheets()->whereDate('finger_print_time', $currentDate)->get()->chunk(2);

        $userVacation = $user->vacations()->whereDate('start', '<=', $currentDate)->whereDate('end', '>=', $currentDate)->get();

        foreach ($userVacation as $vacation) {
            $list->add([
                ['time' => date('H:i', strtotime($vacation->start)), 'label' => 'vs'],
                ['time' => date('H:i', strtotime($vacation->end)), 'label' => 've'],
            ]);
        }

        foreach ($userTimeSheet as $timeSheet) {
            $list->add([
                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'n'],
                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'x'],
            ]);
        }
        foreach ($workTimes as $time) {
            $list->add([
                ['time' => date('H:i', strtotime($time->work_start)), 'label' => 'ws'],
                ['time' => date('H:i', strtotime($time->work_end)), 'label' => 'we'],
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
            if ($list['status'] == 'workingTime') {
                $this->workingTime += $list['value'];
            } elseif ($list['status'] == 'hurry') {
                $this->hurryTime += $list['value'];
            } elseif ($list['status'] == 'vacation') {
                $this->vacationTime += $list['value'];
            } elseif ($list['status'] == 'absence') {
                $this->absenceTime += $list['value'];
            }
        }
        dd(' کارکرد:' . $this->workingTime, ' تعجیل :' . $this->hurryTime, ' غیبت :' . $this->absenceTime, ' مرخصی :' . $this->vacationTime);


    }

}
