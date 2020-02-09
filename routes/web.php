<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::namespace('admin')->prefix('/admin')->group(function () {

    //**************Unit Route**************
    Route::resource('units', 'UnitController');
    Route::get('/units/addShiftForm/{unit}', 'UnitController@addShiftForm')->name('units.addShiftForm');
    Route::post('/units/addShift/{unit}', 'UnitController@addShift')->name('units.addShift');

    //**************Shift Route**************
    Route::resource('shifts', 'ShiftController');
    Route::get('/shift/editTime/{shift}', 'ShiftController@editTime')->name('shifts.editTime');
    Route::get('/shift/getWorkTime/{shift}', 'ShiftController@getWorkTimeAjax')->name('shifts.getWorkTimes');
    Route::post('/shift/addWorkTime/{shift}', 'ShiftController@addWorkTime')->name('shifts.addWorkTime');
    Route::post('/shift/removeWorkTime', 'ShiftController@removeWorkTime')->name('shifts.removeWorkTime');
    Route::get('/shift/editDays/{shift}', 'ShiftController@editDays')->name('shifts.editDays');
    Route::patch('/shift/updateDays/{shift}', 'ShiftController@updateDays')->name('shifts.updateDays');
    //**************WorkTime Route**************
    Route::resource('workTime', 'WorkTimeController');
    //**************Holiday Route**************
    Route::resource('holidays', 'HolidayController');



    //**************TimeSheet Route**************
    Route::resource('timeSheets', 'TimeSheetController');
    Route::get('timeSheetSearch','TimeSheetController@userSearch')->name('timeSheet.userSearch');
    Route::get('timeSheetFilterDate','TimeSheetController@filterDate')->name('timeSheet.filterDate');



    //**************Holiday Route**************
    Route::resource('attendance', 'AttendanceController');
    Route::post('attendance/Report','AttendanceController@getReport')->name('attendance.getReport');


});

Route::resource('users', 'admin\UsersController');
Route::resource('vacationType', 'admin\VacationTypeController');
Route::resource('specialVacation', 'admin\SpecialVacationController');
Route::resource('demandVacation', 'DemandVacationController');
Route::resource('userVacation', 'admin\UserVacationController');
Route::resource('attendanceFiles', 'admin\AttendanceFileController');

Route::resource('roles', 'admin\RoleController')->except(['patch']);
Route::patch('/roles/update/{role}', 'admin\RoleController@update')
    ->name('roles.update');

Route::resource('userRoles', 'admin\UserRoleController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('demandVacation', 'DemandVacationController');
