<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use App\SpecialVacation;
use App\VacationType;
use Illuminate\Http\Request;

class SpecialVacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $specialVacation = SpecialVacation::all();

       // dd(VacationType::find(1)->users()->get());

     //  dd($specialVacation->where('user_id','=',1)->all());

        return view('admin.specialVacations.index', [
            'vacationTypes' => VacationType::all(),
            'users' => User::all(),
            'index' => 1,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->get('vacation_id'), $request->get('user_id'), $request->get('amount'));

        User::find($request->get('user_id'))
            ->setSpecialVacation(
                VacationType::Find($request->get('vacation_id')), $request->get('amount'));

        return redirect(route('specialVacation.index'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
