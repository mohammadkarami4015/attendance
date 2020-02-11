<?php

namespace App\Http\Controllers\admin;

use App\Helper\message;
use App\Helpers\DateFormat;
use App\Http\Controllers\Controller;
use App\Http\Requests\TimeRequest;
use App\Http\Requests\TimeSheetRequest;
use App\Http\Requests\UploadRequest;
use App\Imports\CsvImport;
use App\TimeSheet;
use App\User;
use Carbon\Carbon;
use Cassandra\Time;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class TimeSheetController extends Controller
{

    public function index()
    {
        $timeSheets = TimeSheet::query()->latest()->paginate(20);
        return view('admin/timeSheets/index', compact('timeSheets'));
    }

    public function userSearch(Request $request)
    {
        $timeSheets = TimeSheet::query()->Search($request->get('userSearch'))->get();
        return view('admin.timeSheets.indexSearch', compact('timeSheets'));
    }

    public function filterDate(Request $request)
    {
        $fromDate = DateFormat::toMiladi($request->get('from'));
        $toDate = Carbon::parse(DateFormat::toMiladi($request->get('to')))->addSeconds(86399);
        $timeSheets = TimeSheet::FilterByDate($fromDate, $toDate)->latest()->paginate(20);
        return view('admin.timeSheets.index', compact('timeSheets'));
    }

    public function upload(UploadRequest $request)
    {
        Excel::import(new CsvImport(), request()->file('file'));

        message::show('فایل مورد نظر با موفقیت آپلود شد');
        return back();
    }





    public function create()
    {
        $users = User::all();
        return view('admin.timeSheets.create', compact('users'));
    }


    public function store(TimeSheetRequest $request)
    {
        TimeSheet::create([
            'user_id' => $request->get('user_id'),
            'finger_print_time' => DateFormat::toMiladi($request->get('finger_print_time')),
        ]);
        message::show('اطلاعات مورد نظر با موفقیت ثبت شدند');
        return redirect(route('timeSheets.index'));
    }


    public function show($id)
    {
        //
    }


    public function edit(TimeSheet $timeSheet)
    {
        $users = User::all();
        return view('admin/timeSheets/edit', compact('timeSheet', 'users'));
    }


    public function update(TimeSheetRequest $request, TimeSheet $timeSheet)
    {
        $timeSheet->update([
            'user_id' => $request->get('user_id'),
            'finger_print_time' => DateFormat::toMiladi($request->get('finger_print_time')),
        ]);
        message::show('اطلاعات مورد نظر با موفقیت ویرایش شدند');
        return redirect(route('timeSheets.index'));

    }

    public function destroy(TimeSheet $timeSheet)
    {
        $timeSheet->delete();
        message::show('اطلاعات مورد نظر با موفقیت حذف شدند');
        return back();

    }
}
