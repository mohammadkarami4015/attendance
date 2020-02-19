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

    //**************User Route**************
    Route::resource('users', 'UsersController');
    Route::get('/usersChangePassword','UsersController@changePasswordForm')->name('users.changePasswordForm');
    Route::patch('usersChangePassword','UsersController@changePassword')->name('users.changePassword');
    Route::get('usersSearch','UsersController@searchCode');
    Route::get('usersFilterByUnit','UsersController@filterByUnit');

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
    Route::resource('workTimes', 'WorkTimesController');
    //**************Holiday Route**************
    Route::resource('holidays', 'HolidayController');

    //**************TimeSheet Route**************
    Route::resource('timeSheets', 'TimeSheetController');
    Route::get('timeSheet/uploadFile','TimeSheetController@uploadForm')->name('timeSheet.uploadForm');
    Route::post('timeSheet/uploadFile','TimeSheetController@upload')->name('timeSheet.upload');
    Route::get('timeSheetFilter','TimeSheetController@filter')->name('timeSheet.filter');
    Route::get('timeSheet/checkDouble','TimeSheetController@checkDouble')->name('timeSheet.checkDouble');



    //**************Attendance Route**************
    Route::resource('attendance', 'AttendanceController');
    Route::get('attendanceReport','AttendanceController@getReport');
    Route::get('attendanceCollectIndex', 'AttendanceController@collectIndex')->name('attendance.collectIndex');
    Route::get('attendanceCollectReport','AttendanceController@getCollectReport');
//    Route::post('attendance/CollectReport', 'AttendanceController@getCollectReport')->name('attendance.collectReport');
//    Route::post('attendance/Report','AttendanceController@getReport')->name('attendance.getReport');


//**************Attendance Route**************


});

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
