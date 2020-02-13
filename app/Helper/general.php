<?php


namespace App\Helper;


use App\Helpers\DateFormat;
use App\Imports\CsvImport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class general
{
    public static function fileToCollect($file)
    {
       $file = Excel::toCollection(new CsvImport, $file);
      return  $collectOfFile = $file->flatten(1)->groupBy(0)->map->groupBy(function (Collection $item) {
            return Carbon::parse(DateFormat::toMiladi($item->get(1)))->format('Y-m-d');
        });
    }


}
