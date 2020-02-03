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
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ShahoCollectionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var int
     */
    private $attendance = 0;
    private $vacation = 0;
    private $shift = 0;
    private $holiday = 0 ;
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

    //---------------------------************************--------------------------------------

    public function test_reading_data_from_database(){

        $interestedDate = date('Y-m-d', strtotime('2020-01-01'));
        //dd($interestedDate);
        $generalShift = Shift::create(['title'=> 'شیفت عمومی']);
        $serviceShift = Shift::create(['title'=> 'شیفت خدماتی یک']);


        $generalShift->days()->createMany([
            ['title'=>'saturday'],
            ['title'=> 'sunday'],
            ['title'=> 'monday'],
            ['title'=> 'tuesday'],
            ['title'=> 'wednesday'],
            ['title'=> 'thursday'],
            ['title'=> 'friday'],
        ]);

        $serviceShift->days()->createMany([
            ['title'=>'saturday'],
            ['title'=> 'sunday'],
            ['title'=> 'monday'],
            ['title'=> 'tuesday'],
            ['title'=> 'wednesday'],
            ['title'=> 'thursday'],
            ['title'=> 'friday'],
        ]);

        //dump($generalShift->days()->get()->all());

        $generalShift->days()->find(1)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
            ['start'=> date('H:i', strtotime('14:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        $generalShift->days()->find(2)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
            ['start'=> date('H:i', strtotime('14:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        $generalShift->days()->find(3)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
            ['start'=> date('H:i', strtotime('14:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        $generalShift->days()->find(4)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
            ['start'=> date('H:i', strtotime('14:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);
        $generalShift->days()->find(5)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
            ['start'=> date('H:i', strtotime('14:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        $generalShift->days()->find(6)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','saturday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('13:00'))],
            ['start'=> date('H:i', strtotime('15:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','sunday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('13:00'))],
            ['start'=> date('H:i', strtotime('15:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','monday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('13:00'))],
            ['start'=> date('H:i', strtotime('15:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','tuesday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('13:00'))],
            ['start'=> date('H:i', strtotime('15:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','wednesday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('13:00'))],
            ['start'=> date('H:i', strtotime('15:00')), 'end' =>date('H:i', strtotime('18:00'))],
        ]);

        Day::find($serviceShift->days()->where('title','thursday')->first()->id)->workTimes()->createMany([
            ['start'=> date('H:i', strtotime('8:00')), 'end' =>date('H:i', strtotime('12:00'))],
        ]);

        //dump(Day::find($serviceShift->days()->where('title','wednesday')->first()->id)->workTimes()->get()->all());
        //dump(WorkTime::find($serviceShift->days()->where('title','=','thursday')->first()->id)->get());
      //  dd(bcrypt('123456789'));

        $karami = User::create([
            'name'=>'mohammad',
            'family' =>'karami',
            'personal_code' => '10116',
            'national_code' => '3732569855',
            'password' => '$2y$04$cNg7v8/XOQ11eAFdwBtzAOSkVJ.QuSdISGVYp4Ak7igW1GpaITtry',
            'email' => 'mohammad.karami@gmail.com',
        ]);

        $moradpour = User::create([
            'name'=>'khanom',
            'family' =>'moradi',
            'personal_code' => '10110',
            'national_code' => '3732569555',
            'password' => '$2y$04$cNg7v8/XOQ11eAFdwBtzAOSkVJ.QuSdISGVYp4Ak7igW1GpaITtry',
            'email' => 'moradi@gmail.com',
        ]);

        //dd(Shift::where('title','شیفت عمومی')->first()->id);
        $karami->shifts()->attach(Shift::where('title','شیفت عمومی')->first()->id,['from' => Carbon::now()]);
        //dd($karami->shifts()->first()->days()->where('title','sunday')->first()->workTimes()->get());
        //dd($karami);
        $moradpour->shifts()->attach(Shift::where('title','شیفت خدماتی یک')->first()->id,['from' => Carbon::now()]);
        //dd($moradpour->shifts()->first()->days()->where('title','sunday')->first()->workTimes()->get());
        //dd($user1);

        $karami->timeSheets()->createMany([
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 8:30'))],
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 9:35'))],
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 10:24'))],
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 12:10'))],
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 13:45'))],
            ['finger_print_time' => date('Y-m-d H:i', strtotime('2020-01-01 18:10'))],
        ]);


        DB::table('vacation_types')->insert([
            ['title'=> 'مرخصی استحقاقی', 'amount'=> 17],
            ['title'=> 'مرخصی استعلاجی', 'amount'=> 72],
            ['title'=> 'مرخصی بدون حقوق', 'amount'=> 0],
        ]);

       // dump(DB::table('vacation_types')->get()->all());

        /*$karami->vacations()->create([
            'start' => date('Y-m-d H:i', strtotime('2020-01-01 9:00')),
            'end' => date('Y-m-d H:i', strtotime('2020-01-01 10:00')),
            'vacation_type_id' => 1,
            'is_daily'=> 0,
            'confirmation' => 1,
        ]);

        DB::table('holidays')->insert([
            'start'=> date('Y-m-d H:i', strtotime('2020-01-01 8:00')),
            'end' => date('Y-m-d H:i', strtotime('2020-01-01 9:00')),
            'is_daily'=> 0,
        ]);*/

//-------------------------------------------------------------------------------------------------

        if(count($karami->timeSheets()->get()) % 2 == 0){
            dump('even');
        }else{
            dd('Data is not even ...please check it out...');
        };

 //-----fetching user data and labeling them to n or x -------------------*********----------------------------------------------------------

        $userTimeSheet = collect();

        $state = 'n';

        foreach($karami->timeSheets()->get() as $time){

            $userTimeSheet->push([
                'time' => date('H:i', strtotime($time->finger_print_time)), 'label' => $state
            ]);

            if ($state == 'n') {
                $state = 'x';
            }else{
                $state = 'n';
            }
        }

//------fetching user time shift for a day ----------**********************------------------------------------

        $workTimes = $karami->shifts()->first()->days()->where('title','sunday')->first()->workTimes()->get();

        $userShiftTimes = collect();

        foreach ($workTimes as $time) {

            $userShiftTimes->push([
                'time' => date('H:i', strtotime($time->start)), 'label' => 'ws'
                ]);
            $userShiftTimes->push([
                'time' => date('H:i', strtotime($time->end)), 'label' => 'we'
            ]);
        }

//----- fetching user vacation data from database ----------------------------------***************-----

        $userVacations = collect();

        $vacations = $karami->vacations()->get();

        foreach ($vacations as $time) {

            $userVacations->push([
                'time' => date('H:i', strtotime($time->start)), 'label' => 'vs'
            ]);
            $userVacations->push([
                'time' => date('H:i', strtotime($time->end)), 'label' => 've'
            ]);
        }

        //dd($userVacations);
//------fetching data from holiday table ---------------*******************************------------------

        $holidayTimes = collect();



        $holidays = Holiday::whereDate('start',$interestedDate)->get();
       // dd($holidays->start);
        foreach($holidays as $time){
            $holidayTimes->push([
                'time' => date('H:i', strtotime($time->start)), 'label' => 'hs'
            ]);
            $holidayTimes->push([
                'time' => date('H:i', strtotime($time->end)), 'label' => 'he'
            ]);
        }


//------processing of all data in order to reach valid data and period of time---------------------------

        //dump($userShiftTimes);

        $userTimeSheet = $userTimeSheet->merge($userShiftTimes);

        $userTimeSheet = $userTimeSheet->merge($userVacations);
     //  dd($userTimeSheet);
        $userTimeSheet = $userTimeSheet->merge($holidayTimes);

        $userTimeSheet = $userTimeSheet->sortBy('time');
        $finalTimeSheet = array_values($userTimeSheet->toArray());
        //dd($finalTimeSheet);

        for ($counter = 1; $counter < count($finalTimeSheet); $counter++) {
            $firstItem = $finalTimeSheet[$counter - 1];
            $secondItem = $finalTimeSheet[$counter];
            dump($firstItem['label']);
            dump($secondItem['label']);
            $status = $this->checkItems($firstItem, $secondItem);
            dump($firstItem['time'] . ' ' . $status . ' ' . $secondItem['time']);
        }

    }

    public function testCollection()
    {

        $timeSheets = collect([
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 6:00')), 'label' => 'n'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 7:00')), 'label' => 'x'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 7:50')), 'label' => 'n'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 9:35')), 'label' => 'x'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 10:29')), 'label' => 'n'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 12:10')), 'label' => 'x'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 13:55')), 'label' => 'n'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 15:00')), 'label' => 'x'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 16:00')), 'label' => 'n'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 18:10')), 'label' => 'x'],
        ]);

        $shifts = collect([
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 8:00')), 'label' => 'ws'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 12:00')), 'label' => 'we'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 14:00')), 'label' => 'ws'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 18:00')), 'label' => 'we'],
        ]);

        $vacations = collect([
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 9:30')), 'label' => 'vs'],
            ['time' => date('Y-m-d H:i', strtotime('2020-01-01 10:30')), 'label' => 've'],
        ]);

        $list = $timeSheets->merge($shifts->merge($vacations));
        $list2 = $list->sortBy('time');
        $sortedList = array_values($list2->toArray());
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


    public function checkItems(array $firstItem, array $secondItem)
    {
        if ($firstItem['label'] == 'n') {
            $this->attendance = 1;
        } elseif ($firstItem['label'] == 'x') {
            $this->attendance = 0;
        }

        if ($firstItem['label'] == 'ws') {
            $this->shift = 1;
        } elseif ($firstItem['label'] == 'we') {
            $this->shift = 0;
        }

        if ($firstItem['label'] == 'vs') {
            $this->vacation = 1;
        } elseif ($firstItem['label'] == 've') {
            $this->vacation = 0;
        }

        if ($firstItem['label'] == 'hs') {
            $this->holiday = 1;
        } elseif ($firstItem['label'] == 'he') {
            $this->holiday = 0;
        }

        if ($this->attendance == 0 && $this->shift == 0) {
            return 'invalid';
        }

        if ($this->attendance == 0 && $this->shift == 1) {

            if ($this->vacation == 0 && $this->holiday == 0) {
                return 'absence';
            }

            if ($this->vacation == 1 && $this->holiday == 0) {
                return 'vacation';
            }

            if ($this->holiday == 1) {
                return 'holiday';
            }
        }

        if ($this->attendance == 1 && $this->shift == 0) {
            return 'overTime';
        }

        if ($this->attendance == 1 && $this->shift == 1) {
            if ($this->holiday == 1) {
                return 'overTime';
            } else {
                return 'workingTime';
            }
        }
    }



}
