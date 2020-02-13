<?php

namespace App\Http\Controllers\admin;

use App\Exceptions\UploadException;
use App\Helper\general;
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
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Builder;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpParser\Node\Stmt\DeclareDeclare;
use Symfony\Component\Console\Helper\Helper;
use function foo\func;

class TimeSheetController extends Controller
{

    public function index()
    {
        $users = User::all();
        $timeSheets = TimeSheet::query()->orderByDesc('finger_print_time')->paginate(20);
        return view('admin/timeSheets/index', compact('timeSheets', 'users'));
    }


    public function filter(Request $request)
    {
        $fromDate = Carbon::parse(DateFormat::toMiladi($request->get('from')));
        $toDate = Carbon::parse(DateFormat::toMiladi($request->get('to')))->addSeconds(86399);
        $timeSheets = TimeSheet::FilterByDate($fromDate, $toDate, $request->user_id)->latest()->get();
        return view('admin.timeSheets.indexFilter', compact('timeSheets'));
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


    public function checkDouble()
    {
        $singleTimeSheet = TimeSheet::checkDouble();
        return view('admin/timeSheets/singleCheck', compact('singleTimeSheet'));

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

    public function upload(UploadRequest $request)
    {
        $collectOfFile = general::fileToCollect($request->file('file'));
        $timeSheets = TimeSheet::getFingerTime();

        if ($this->isDuplicate($collectOfFile,$timeSheets))
            return back()->withErrors('فایل وارد شده شامل دیتای تکراری است لطفا آنرا اصلاح کنید');

        try {
            Excel::import(new CsvImport(), request()->file('file'));
            message::show('فایل مورد نظر با موفقیت آپلود شد');

        } catch (\Exception $exception) {

            throw new UploadException($exception->getMessage());
        }
        return back();
    }

    public function isDuplicate($file,$timeSheets)
    {
       return $file->values()->map->keys()->map->intersect($timeSheets)->map->isNotEmpty()->contains('true') ;
    }
}
