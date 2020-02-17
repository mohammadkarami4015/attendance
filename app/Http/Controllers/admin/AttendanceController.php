<?php

namespace App\Http\Controllers\admin;

use App\Helper\general;
use App\Helpers\DateFormat;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

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
        $startDate = Carbon::parse(DateFormat::toMiladi($request->start_date));
        $endDate = Carbon::parse(DateFormat::toMiladi($request->end_date));
        $reportList = $user->getReportBetweenDays($startDate, $endDate);
        return view('admin.attendance.showReportAjax', [
            'reportList' => $reportList,
            'user' => User::find($request->user_id),
        ]);
    }

    public function collectIndex()
    {
        $users = User::all();
        $userIndex = implode(',', $users->pluck('id')->toArray());
        return view('admin.attendance.collectIndex', compact('users', 'userIndex'));

    }

    public function getCollectReport(Request $request)
    {
        $users = explode(',', $request->get('user_id'));
        $helper = new general();
        $list = $helper->getSumOfCollect(
            User::getReportForAnyUser(
                $users,
                $request->get('start_date'),
                $request->get('end_date'))
        );

        return view('admin.attendance.showCollectReportAjax', [
            'collectList' => $list,
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
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
