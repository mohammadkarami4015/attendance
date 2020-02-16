<?php

namespace App\Http\Controllers\admin;

use App\Helper\general;
use App\Helpers\DateFormat;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $reportList = collect();

        while ($startDate <= $endDate) {
            if ($user->getReport($startDate) == 0)
                return '<h3 align="center" class="text-danger">شیفت کاری در این تاریخ تعریف نشده </h3>';

            elseif ($user->getReport($startDate) == 1)
                return '<h3 align="center" class="text-danger">لطفا داده های ورود و خروج را بررسی کنید </h3>';

            else {
                $reportList->add($user->getReport($startDate));
                $startDate->addDay();
            }
        }

        return view('admin.attendance.showReportAjax', [
            'reportList' => $reportList,
            'user' => User::find($request->user_id),
        ]);

    }

    public function collectIndex()
    {
        $users = User::all();
        return view('admin.attendance.collectIndex', compact('users'));

    }

    public function getCollectReport(Request $request)
    {
        $users = $request->get('user_id');

        $helper = new general();
        $collectList = collect();

        foreach ($users as $value) {
            $user = User::query()->find($value);
            $reportList = collect();

            $startDate = Carbon::parse(DateFormat::toMiladi($request->get('start_date')));
            $endDate = Carbon::parse(DateFormat::toMiladi($request->get('end_date')));

            while ($startDate <= $endDate) {
                $data = $user->getReport($startDate);
                if ($data == 0) {
                    return '<h3 align="center" class="text-danger">شیفت کاری در این تاریخ تعریف نشده </h3>';
                } elseif ($data == 1) {
                    return '<h3 align="center" class="text-danger">لطفا داده های ورود و خروج را بررسی کنید </h3>';
                } else {
                    $reportList->add($data['sumOfStatus']);
                    $startDate->addDay();
                }

            }

            $collectList->add([$reportList->toArray(), $user]);
        }

        $finalList = collect();

        foreach ($collectList as $collect) {
            foreach ($collect[0] as $value) {
                $helper->setSum($value);
            }
            $finalList->add(['finalList' => $helper->getSum(), 'user' => $collect[1]]);
            $helper->refreshList();
        }

        return view('admin.attendance.showCollectReport', [
            'collectList' => $finalList,
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
