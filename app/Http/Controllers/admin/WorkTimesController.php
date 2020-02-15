<?php

namespace App\Http\Controllers\admin;

use App\Day;
use App\Helper\message;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkTimeRequest;
use App\WorkTime;
use Illuminate\Http\Request;

class WorkTimesController extends Controller
{

    public function index()
    {
        $workTimes = WorkTime::with('dayShift.day', 'dayShift.shift')->get();

        return view('admin.workTimes.index', compact('workTimes'));

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


    public function edit(WorkTime $workTime)
    {
        return view('admin.workTimes.edit',compact('workTime'));
    }


    public function update(WorkTimeRequest $request, WorkTime $workTime)
    {
        $workTime->update($request->validated());
        message::show('زمان کاری مورد نظر با موفقیت ویرایش شد ');
        return back();

    }


    public function destroy(WorkTime $workTime)
    {
        $workTime->delete();
        message::show('زمان کاری مورد نظر با موفقیت حذف شد');
        return back();

    }
}
