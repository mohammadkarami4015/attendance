<?php

namespace App\Http\Controllers\admin;

use App\Day;
use App\DayShift;
use App\Helper\message;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Http\Requests\TimeRequest;
use App\Http\Requests\WorkTimeRequest;
use App\Shift;
use App\Unit;
use App\WorkTime;
use Carbon\Carbon;
use http\Env\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Fqsen;
use function foo\func;

class ShiftController extends Controller
{

    public function index()
    {
        $shifts = Shift::query()->latest()->paginate(20);
        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        $days = Day::all();
        return view('admin.shifts.create', compact('days'));
    }

    public function store(ShiftRequest $request)
    {
        $shift = Shift::query()->create($request->validated());
        $shift->days()->sync($request->days);
        return back();

    }

    public function show(Shift $shift)
    {
        return view('admin.shifts.show', [
            'shift' => $shift,
            'days' => $shift->getDay()
        ]);
    }

    public function editTime(Shift $shift)
    {
        $days = $shift->getDay();
        return view('admin.shifts.editTime', compact('days', 'shift'));
    }

    public function getWorkTimeAjax(Request $request, Shift $shift)
    {
        $workTime = WorkTime::getCurrentWorkTimes($shift, $request->day);
        return view('admin/shifts/editWorkTimeAjax', compact('workTime'));
    }

    public function addWorkTime(WorkTimeRequest $request, Shift $shift)
    {
        $days = DayShift::getDays($shift, $request->days);
        foreach ($days as $day) {
            Shift::addWorkTime($request->ws, $request->we, $day);
        }
        return back();
    }

    public function removeWorkTime(TimeRequest $request)
    {
        foreach ($request->workTimes as $time)
            WorkTime::removeTime($time);
        return back();

    }

    public function editDays(Shift $shift)
    {
        $currentDays = $shift->getDay();

        $days = Day::all();
        return view('admin.shifts.editDay', compact('shift', 'days', 'currentDays'));
    }

    public function updateDays(Request $request, Shift $shift)
    {
        $shift->updateDays($request->days);
        $newDays = $shift->getAddedDays($request->days);
        $shift->days()->attach($newDays);
        message::show('روزهای کاری با موفقیت ویرایش شدند');
        return back();


//        $removeDays = (($shift->getDay())->diff(Day::find($request->dayss)))->pluck('id')->toArray();
//        $newDays=Day::find($request->dayss)->diff($shift->getDay());
//        $value = DayShift::query()->whereIn('day_id', $removeDays)->where('to', null)->where('shift_id', $shift->id)->get();
//        foreach ($value as $day) {
//                $day->to = now();
//                $day->save();
//            }


    }

//********last method
//    public
//    function addDays(Request $request, Shift $shift)
//
//    {
//        $shift->days()->attach($request->days);
//        message::show('روزهای مورد نظر با موفقیت ثبت شدند');
//        return redirect(route('shifts.index'));
//
//    }

//    public
//    function removeDays(Request $request, Shift $shift)
//    {
//        $dayShift = $shift->getPivotDay($request->days);
//        Shift::removeDays($dayShift);
//        return redirect(route('shifts.index'));
//
//    }

    public function edit(Shift $shift)
    {

        return view('admin.shifts.edit', compact('shift'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update($request->validated());
        Shift::showMessage('ویرایش با موفقیت انجام شد');
        return redirect(route('shifts.index'));

    }

    public
    function destroy(Shift $shift)
    {
        //
    }
}
