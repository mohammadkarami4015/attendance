<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Shift;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UnitController extends Controller
{

    public function index()
    {
        $units = Unit::query()->latest()->paginate(20);
        return view('admin/units.index', compact('units'));
    }


    public function create()
    {
        return view('admin/units.create');
    }


    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        session()->flash('flash_message', 'گروه کاری جدید با موفقیت ثبت شد');
        return back();
    }


    public function show($id)
    {
        //
    }


    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }


    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());
        session()->flash('flash_message', 'گروه کاری مورد نظر با موفقیت ویرایش شد');
        return back();
    }


    public function destroy(Unit $unit)
    {
        $unit->delete();
        session()->flash('flash_message', 'گروه کاری مورد نظر با موفقیت حذف شد');
        return back();

    }

    public function addShiftForm(Unit $unit)
    {
        $shifts = Shift::all();
        return view('admin.units.addShift', compact('shifts', 'unit'));
    }

    public function addShift(Unit $unit, Request $request)
    {
        $currentShift = $unit->getCurrentShift();
        if ($unit->shifts()->count() == 0) {
            $unit->addShift($request->shift);
            return back();
        } elseif ($currentShift->id == (int)$request->shift) {
            return back()->withErrors('شیفت انتخابی تکراری است');
        } else {
            $currentShift->pivot->to = Carbon::now();
            $currentShift->pivot->save();
            $unit->addShift($request->shift);
            return back();
        }
    }
}
