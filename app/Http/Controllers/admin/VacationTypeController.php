<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\VacationMeasurement;
use App\VacationPeriodTime;
use App\VacationType;
use Illuminate\Http\Request;

class VacationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$vacationTypes = VacationType::all();
      //  dd(VacationPeriodTime::all());

        return view('admin.vacationTypes.index', [
            'vacationTypes'=>  VacationType::all(),
            'vacation_period_time' => VacationPeriodTime::all(),
            'vacation_measurement' => VacationMeasurement::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.vacationTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request->get('vacation_period_time_id'));

       // dd($request->get('vacation_measurement_id'));

        VacationType::create([
            'title' => $request->get('title'),
            'default_amount' => $request->get('default_amount'),
            'vacation_period_time_id' => $request->get('vacation_period_time_id'),
            'vacation_measurement_id' => $request->get('vacation_measurement_id'),
        ]);
         return redirect()->back();
        //$vacationTypes = VacationType::all();

        /*return view('admin.vacationTypes.index', [
            'vacationTypes'=> VacationType::all()
        ]);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VacationType $vacationType
     * @return void
     */
    public function edit(VacationType $vacationType)
    {
        return view('admin.vacationTypes.edit',[
            'vacationType' => $vacationType,
            'vacation_period_time' => VacationPeriodTime::all(),
            'vacation_measurement' => VacationMeasurement::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param VacationType $vacationType
     * @return void
     */
    public function update(Request $request,VacationType $vacationType)
    {
        $vacationType->update([
            'title' => $request->get('title'),
            'default_amount' => $request->get('default_amount'),
            'vacation_period_time_id' => $request->get('vacation_period_time_id'),
            'vacation_measurement_id' => $request->get('vacation_measurement_id'),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param VacationType $vacationType
     * @return void
     */
    public function destroy(VacationType $vacationType)
    {
        $vacationType->delete();
        return redirect(route('vacationType.index'));
    }
}
