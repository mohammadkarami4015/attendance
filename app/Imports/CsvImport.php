<?php

namespace App\Imports;

use App\Helpers\DateFormat;
use App\TimeSheet;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class CsvImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new TimeSheet([
            'user_id' =>$row[0],
            'finger_print_time'=>DateFormat::toMiladi($row[1])
        ]);
    }
}
