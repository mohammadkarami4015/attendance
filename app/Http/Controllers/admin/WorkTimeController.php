<?php

namespace App\Http\Controllers\admin;

use App\Day;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkTimeRequest;
use App\Shift;
use App\WorkTime;
use Illuminate\Http\Request;

class WorkTimeController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {

    }


    public function store(Request $request,Shift $shift)
    {


//        Shift::addUnit($request->days[0], $request->unit);
//        foreach ($request->days as $day) {
//            WorkTime::addWorkTime($request->ws, $request->we, $day);
//        }
        return redirect(route('shifts.index'));
    }


    public function show($id)
    {
        //
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
