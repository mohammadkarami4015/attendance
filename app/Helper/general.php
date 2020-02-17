<?php


namespace App\Helper;


use App\Helpers\DateFormat;
use App\Imports\CsvImport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class general
{
    public $sumAbsenceTime = 0;
    public $sumAttendance = 0;
    public $sumOverTime = 0;
    public $sumVacation = 0;


    public static function fileToCollect($file)
    {
        $file = Excel::toCollection(new CsvImport, $file);
        return $collectOfFile = $file->flatten(1)->groupBy(0)->map->groupBy(function (Collection $item) {
            return Carbon::parse(DateFormat::toMiladi($item->get(1)))->format('Y-m-d');
        });
    }

    public function setSum($list)
    {
        if ($list != []) {
            $this->sumAttendance += $list['کارکرد'];
            $this->sumAbsenceTime += $list['غیبت'];
            $this->sumOverTime += $list['اضافه کاری'];
            $this->sumVacation += $list['مرخصی'];
        }
    }

    public function getSum()
    {
        return [
            'کارکرد' => $this->sumAttendance,
            'غیبت' => $this->sumAbsenceTime,
            'اضافه کاری' => $this->sumOverTime,
            'مرخصی' => $this->sumVacation,
        ];

    }

    public function refreshList()
    {
        $this->sumAbsenceTime = 0;
        $this->sumAttendance = 0;
        $this->sumOverTime = 0;
        $this->sumVacation = 0;
    }

    public function getSumOfCollect($collectList)
    {
        $finalList = collect();
        foreach ($collectList as $collect) {
            foreach ($collect[0] as $value) {
                $this->setSum($value);
            }
            $finalList->add(['finalList' => $this->getSum(), 'user' => $collect[1]]);
            $this->refreshList();
        }
        return $finalList;

    }


}
