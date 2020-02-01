<?php

namespace App\Http\Controllers\admin;

use App\Day;
use App\DayShift;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Shift;
use App\Unit;
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
            'days'=>$shift->getDay()
        ]);
    }


    public function addTimeForm(Shift $shift)
    {
        $days = $shift->getDay();
        return view('admin.shifts.addTime', compact('days', 'shift'));

    }

    public function addWorkTime(Request $request, Shift $shift)
    {
        $days = DayShift::getDays($shift, $request->days);
        foreach ($days as $day) {
            Shift::addWorkTime($request->ws, $request->we, $day);
        }
        return back();
    }

    public function editDays(Shift $shift)
    {
        $currentDays = $shift->getDay();
        $days = Day::all()->diff($currentDays);
        return view('admin.shifts.editDay', compact('shift', 'days', 'currentDays'));
    }

    public function addDays(Request $request, Shift $shift)
    {
        $shift->days()->attach($request->days);
        session()->flash('flash_message', 'روزهای مورد نظر با موفقیت ثبت شدند');
        return redirect(route('shifts.index'));

    }

    public function removeDays(Request $request, Shift $shift)
    {
        $dayShift = $shift->getPivotDay($request->days);
        Shift::removeDays($dayShift);
        return redirect(route('shifts.index'));

    }

    public function edit(Shift $shift)
    {

        return view('admin.shifts.edit', compact( 'shift'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update($request->validated());
        Shift::showMessage('ویرایش با موفقیت انجام شد');
        return redirect(route('shifts.index'));

    }

    public function destroy(Shift $shift)
    {
        //
    }
}
