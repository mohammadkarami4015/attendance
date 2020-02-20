<?php

namespace App\Http\Controllers\admin;

use App\Helper\message;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayRequest;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::query()->latest()->paginate(20);
        return view('admin.holidays.index', compact('holidays'));
    }

    public function create()
    {
        return view('admin.holidays.create');
    }


    public function store(HolidayRequest $request)
    {
        Holiday::query()->create(Holiday::data($request));
        message::show('تعطیلی جدید با موفقیت ثبت شد');
        return redirect(route('holidays.index'));

    }


    public function show($id)
    {

    }


    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }


    public function update(HolidayRequest $request, Holiday $holiday)
    {
        $holiday->update(Holiday::data($request));
        message::show('تعطیلی  با موفقیت ویرایش شد');
        return redirect(route('holidays.index'));

    }


    public function destroy(Holiday $holiday)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $holiday->delete();
        message::show('تعطیلی  با موفقیت حذف شد');
        return back();
    }
}
