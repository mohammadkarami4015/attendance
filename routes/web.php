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


use App\Http\Controllers\admin\AttendanceController;
use App\Http\Controllers\admin\HolidayController;
use App\Http\Controllers\admin\ShiftController;
use App\Http\Controllers\admin\TimeSheetController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\WorkTimesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    Auth::routes();

});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/admin')->group(function () {

    Route::name('users.')->prefix('/users')->group(function () {

        Route::get('/change-password', [UsersController::class, 'changePasswordForm'])
            ->name('changePasswordForm');

        Route::patch('/change-password', [UsersController::class, 'changePassword'])
            ->name('changePassword');

        Route::get('/searchByCode', [UsersController::class, 'searchByCode'])
            ->name('searchByCode');

        Route::get('/filterByUnit', [UsersController::class, 'filterByUnit'])
            ->name('filterByUnit');



    });

    Route::name('units.')->prefix('/units')->group(function () {

        Route::get('/addShiftForm/{unit}', [UnitController::class, 'addShiftForm'])
            ->name('addShiftForm');

        Route::post('/addShift/{unit}', [UnitController::class, 'addShift'])
            ->name('addShift');

    });

    Route::name('shifts.')->prefix('/shifts')->group(function () {

        Route::get('/editTime/{shift}', [ShiftController::class, 'editTime'])
            ->name('editTime');

        Route::get('/getWorkTime/{shift}', [ShiftController::class, 'getWorkTimeAjax'])
            ->name('getWorkTime');

        Route::post('/addWorkTime/{shift}', [ShiftController::class, 'addWorkTime'])
            ->name('addWorkTime');

        Route::post('/removeWorkTime', [ShiftController::class, 'removeWorkTime'])
            ->name('removeWorkTime');

        Route::get('/editDays/{shift}', [ShiftController::class, 'editDays'])
            ->name('editDays');

        Route::patch('/updateDays/{shift}', [ShiftController::class, 'updateDays'])
            ->name('updateDays');

    });

    Route::name('timeSheets.')->prefix('/timeSheets')->group(function () {

        Route::get('/uploadFile', [TimeSheetController::class, 'uploadForm'])
            ->name('uploadForm');

        Route::post('/uploadFile', [TimeSheetController::class, 'upload'])
            ->name('upload');

        Route::get('/filter', [TimeSheetController::class, 'filter'])
            ->name('filter');

        Route::get('/checkDouble', [TimeSheetController::class, 'checkDouble'])
            ->name('checkDouble');



    });

    Route::name('attendance.')->prefix('/attendance')->group(function () {


        Route::get('/report', [AttendanceController::class, 'getReport'])
            ->name('report');

        Route::get('/collectIndex', [AttendanceController::class, 'collectIndex'])
            ->name('collectIndex');

        Route::get('/collectReport', [AttendanceController::class, 'getCollectReport'])
            ->name('collectReport');

//        Route::post('/CollectReport', [AttendanceController::class, 'getCollectReport'])->name('attendance.collectReport');

//        Route::post('/Report', [AttendanceController::class, 'getReport'])->name('attendance.getReport');

    });

    Route::resource('/units', UnitController::class);
    Route::resource('/users', UsersController::class);
    Route::resource('/shifts', ShiftController::class);
    Route::resource('/workTimes', WorkTimesController::class);
    Route::resource('/holidays', HolidayController::class);
    Route::resource('/timeSheets', TimeSheetController::class);
    Route::resource('/attendance', AttendanceController::class)->only('index');

});
//
//Route::resource('vacationType', 'admin\VacationTypeController');
//Route::resource('specialVacation', 'admin\SpecialVacationController');
//Route::resource('demandVacation', 'DemandVacationController');
//Route::resource('userVacation', 'admin\UserVacationController');
//Route::resource('attendanceFiles', 'admin\AttendanceFileController');
//
//Route::resource('roles', 'admin\RoleController')->except(['patch']);
//Route::patch('/roles/update/{role}', 'admin\RoleController@update')
//    ->name('roles.update');
//
//Route::resource('userRoles', 'admin\UserRoleController');
//
//
//Route::get('/home', 'HomeController@index')->name('home');
//Route::resource('demandVacation', 'DemandVacationController');
