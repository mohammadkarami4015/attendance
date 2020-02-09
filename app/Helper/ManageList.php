<?php


namespace App\Helpers;

use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class ManageList
{
    public $attendance = 0;
    public $vacation = 0;
    public $shift = 0;
    public $holiday = 0;
    public $amount = 0;
    public $absenceTime = 0;
    public $vacationTime = 0;
    public $workingTime = 0;
    public $overTime = 0;
    public $holidayTime = 0;

    public function addTimeToList($collect, $list, $label1, $label2)
    {
        foreach ($collect as $time) {
            $list->add([
                ['time' => date('H:i', strtotime($time->start)), 'label' => $label1],
                ['time' => date('H:i', strtotime($time->end)), 'label' => $label2],
            ]);
        }
        return $list;
    }

    public function addTimeSheetToList($collect, $list)
    {
        foreach ($collect as $timeSheet) {
            $list->add([
                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'entry'],
                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'exit'],
            ]);
        }
        return $list;
    }

    public function sortList($list)
    {
        return array_values($list->flatten(1)->sortBy('time')->toArray());
    }

    public function getReport($rawList)
    {
        $finalList = collect();
        for ($counter = 1; $counter < count($rawList); $counter++) {
            $firstItem = $rawList[$counter - 1];
            $secondItem = $rawList[$counter];
            $this->setItem($firstItem);
            $finalList->add([
                ['item1' => $firstItem['time'],
                    'item2' => $secondItem['time'],
                    'value' => Carbon::parse($firstItem['time'])->diffInMinutes($secondItem['time']),
                    'status' => $this->checkStatus()]
            ]);
        }
        return $finalList->flatten(1);

    }

    public function setItem(array $firstItem)
    {
        if ($firstItem['label'] == 'entry') {
            $this->attendance = 1;
        } elseif ($firstItem['label'] == 'exit') {
            $this->attendance = 0;
        }

        if ($firstItem['label'] == 'start_shift') {
            $this->shift = 1;
        } elseif ($firstItem['label'] == 'end_shift') {
            $this->shift = 0;
        }

        if ($firstItem['label'] == 'start_vacation') {
            $this->vacation = 1;
        } elseif ($firstItem['label'] == 'end_vacation') {
            $this->vacation = 0;
        }

        if ($firstItem['label'] == 'start_holiday') {
            $this->holiday = 1;
        } elseif ($firstItem['label'] == 'end_holiday') {
            $this->holiday = 0;
        }

    }

    public function checkStatus()
    {
        if ($this->attendance == 0 && $this->shift == 0) {
            return 'وقت آزاد';
        }

        if ($this->attendance == 0 && $this->shift == 1) {

            if ($this->vacation == 0 && $this->holiday == 0) {
                return 'غیبت';
            }

            if ($this->vacation == 1 && $this->holiday == 0) {
                return 'مرخصی';
            }

            if ($this->holiday == 1) {
                return 'تعطیلی';
            }
        }

        if ($this->attendance == 1 && $this->shift == 0) {
            return 'اضافه کاری';
        }

        if ($this->attendance == 1 && $this->shift == 1) {
            if ($this->holiday == 1) {
                return 'اضافه کاری';
            } else {
                return 'کارکرد';
            }
        }
    }

    public function sumOfStatus($reportList)
    {

        foreach ($reportList as $list) {
            if ($list['status'] == 'کارکرد') {
                $this->workingTime += $list['value'];
            } elseif ($list['status'] == 'تعطیلی') {
                $this->holidayTime += $list['value'];
            } elseif ($list['status'] == 'غیبت') {
                $this->absenceTime += $list['value'];
            } elseif ($list['status'] == 'اضافه کاری') {
                $this->overTime += $list['value'];
            } elseif ($list['status'] == 'مرخصی') {
                $this->vacationTime += $list['value'];
            }

        }
        return $this->finalList();
    }

    public function finalList()
    {
        return collect([
            'کارکرد' => $this->workingTime,
            'غیبت' => $this->absenceTime,
            'اضافه کاری' => $this->overTime,
            'تعطیلی' => $this->holidayTime,
            'مرخصی' => $this->vacationTime
        ]);
    }

}
