<?php

namespace App\Http\Controllers\admin;

use App\Day;
use App\Helper\message;
use App\Helpers\DateFormat;
use App\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayRequest;
use App\User;
use Illuminate\Http\Request;
use test\Mockery\Adapter\Phpunit\BaseClassStub;

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
        Holiday::create(Holiday::data($request));
        message::show('تعطیلی جدید با موفقیت ثبت شد');
        return redirect(route('holidays.index'));

    }


    public function show($id)
    {

    }


    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit',compact('holiday'));
    }


    public function update(HolidayRequest $request, Holiday $holiday)
    {
        $holiday->update(Holiday::data($request));
        message::show('تعطیلی  با موفقیت ویرایش شد');
        return redirect(route('holidays.index'));

    }


    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        message::show('تعطیلی  با موفقیت حذف شد');
        return back();
    }
}
