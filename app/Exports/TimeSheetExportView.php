<?php

namespace App\Exports;

use App\TimeSheet;
use Maatwebsite\Excel\Concerns\FromCollection;

class TimeSheetExportView implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TimeSheet::all();
    }
}
