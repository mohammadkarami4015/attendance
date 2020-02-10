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


    public function index()
    {
        $users = User::all();
        return view('admin.attendance.index', compact('users'));

    }

    public function getReport(Request $request)
    {
        $user = User::query()->find($request->user_id);
        $collectList = collect();
        $startDate = Carbon::parse(DateFormat::toMiladi($request->start_date));
        $endDate = Carbon::parse(DateFormat::toMiladi($request->end_date));

        while ($startDate <= $endDate) {
            if ($user->getReport($startDate) == 0)
                return view('admin.attendance.index', ['users' => User::all()])->withErrors(['لطفا شیفت کاری کاربر را در این روزها مشخص کنید']);
            elseif ($user->getReport($startDate) == 1)
                return view('admin.attendance.index', ['users' => User::all()])->withErrors(['لطفا روزهای کاری را مشخص کنید']);
            else {
                $collectList->add($user->getReport($startDate));
                $startDate->addDay();
            }
        }

        return view('admin.attendance.showReport', [
            'collectList' => $collectList,
            'user' => User::find($request->user_id),
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
