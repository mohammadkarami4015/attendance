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
        message::show('شیفت جدید با موفقیت ثبت شد');
        return back();

    }

    public function show(Shift $shift)
    {
        return view('admin.shifts.show', [
            'shift' => $shift,
            'days' => $shift->getUsageDay()
        ]);
    }

    public function editTime(Shift $shift)
    {
        $days = $shift->getUsageDay();
        return view('admin.shifts.editTime', compact('days', 'shift'));
    }

    public function getWorkTimeAjax(Request $request, Shift $shift)
    {
        $workTime = WorkTime::getCurrentWorkTimes($shift, $request->day);
        return view('admin/shifts/editWorkTimeAjax', compact('workTime'));
    }

    public function addWorkTime(WorkTimeRequest $request, Shift $shift)
    {
        $dayShifts = $shift->dayShift($request->days);

        foreach ($dayShifts as $dayShift) {
            $dayShift->addWorkTime($request->ws, $request->we);
        }
        return back();
    }

    public function removeWorkTime(TimeRequest $request)
    {
        foreach ($request->workTimes as $workTime)
            WorkTime::query()->find($workTime)->removeTime();
        return back();
    }

    public function editDays(Shift $shift)
    {
        $usageDays = $shift->getUsageDay();
        $days = Day::all();
        return view('admin.shifts.editDay', compact('shift', 'days', 'usageDays'));
    }

    public function updateDays(Request $request, Shift $shift)
    {
        $shift->updateDays($request->days);
        $newDays = $shift->getAddedDays($request->days);
        $shift->days()->attach($newDays);
        message::show('روزهای کاری با موفقیت ویرایش شدند');
        return back();
    }


    public function edit(Shift $shift)
    {
        return view('admin.shifts.edit', compact('shift'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update($request->validated());
        message::show('ویرایش با موفقیت انجام شد');
        return redirect(route('shifts.index'));

    }

    public
    function destroy(Shift $shift)
    {
        //
    }
}
