<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Attendance extends Model
{
    static protected $attendance = 0;
    static protected $vacation = 0;
    static protected $shift = 0;
    static protected $holiday = 0;
    static protected $amount = 0;
    static protected $absenceTime = 0;
    static protected $vacationTime = 0;
    static protected $workingTime = 0;
    static protected $overTime = 0;
    static protected $holidayTime = 0;


    public static function getByCondition($var, $currentDate)
    {
        return $var->whereDate('start', '<=', $currentDate)
            ->whereDate('end', '>=', $currentDate)
            ->get();

    }

    public static function addToList($collect, $list, $label1, $label2)
    {
        foreach ($collect as $time) {
            $list->add([
                ['time' => date('H:i', strtotime($time->start)), 'label' => $label1],
                ['time' => date('H:i', strtotime($time->end)), 'label' => $label2],
            ]);
        }
        return $list;
    }

    public static function addTimeSheetToList($collect, $list)
    {
        foreach ($collect as $timeSheet) {
            $list->add([
                ['time' => date('H:i', strtotime($timeSheet->first()->finger_print_time)), 'label' => 'ورود'],
                ['time' => date('H:i', strtotime($timeSheet->last()->finger_print_time)), 'label' => 'خروج'],
            ]);
        }
        return $list;
    }

    public static function sortList($list)
    {
        return array_values($list->flatten(1)->sortBy('time')->toArray());
    }

    public static function getReport($rawList)
    {
        $finalList = collect();
        for ($counter = 1; $counter < count($rawList); $counter++) {
            $firstItem = $rawList[$counter - 1];
            $secondItem = $rawList[$counter];
            $amount = Carbon::parse($firstItem['time'])->diffInMinutes($secondItem['time']);
            self::setItem($firstItem, $secondItem);
            $finalList->add([
                ['item1' => $firstItem['time'],
                    'item2' => $secondItem['time'],
                    'value' => $amount,
                    'status' => self::checkStatus()]
            ]);
        }
        return $finalList->flatten(1);

    }

    public static function setItem(array $firstItem, array $secondItem)
    {
        if ($firstItem['label'] == 'ورود') {
            self::$attendance = 1;
        } elseif ($firstItem['label'] == 'خروج') {
            self::$attendance = 0;
        }

        if ($firstItem['label'] == 'شروع شیفت') {
            self::$shift = 1;
        } elseif ($firstItem['label'] == 'پایان شیفت') {
            self::$shift = 0;
        }

        if ($firstItem['label'] == 'شروع مرخصی') {
            self::$vacation = 1;
        } elseif ($firstItem['label'] == 'پایان مرخصی') {
            self::$vacation = 0;
        }

        if ($firstItem['label'] == 'شروع تعطیلی') {
            self::$holiday = 1;
        } elseif ($firstItem['label'] == 'پایان تعطیلی') {
            self::$holiday = 0;
        }


    }

    public static function checkStatus()
    {
        if (self::$attendance == 0 && self::$shift == 0) {
            return 'invalid';
        }

        if (self::$attendance == 0 && self::$shift == 1) {

            if (self::$vacation == 0 && self::$holiday == 0) {
                return 'غیبت';
            }

            if (self::$vacation == 1 && self::$holiday == 0) {
                return 'مرخصی';
            }

            if (self::$holiday == 1) {
                return 'تعطیلی';
            }
        }

        if (self::$attendance == 1 && self::$shift == 0) {
            return 'اضافه کاری';
        }

        if (self::$attendance == 1 && self::$shift == 1) {
            if (self::$holiday == 1) {
                return 'اضافه کاری';
            } else {
                return 'کارکرد';
            }
        }
    }

    public static function sumOfStatus($reportList){

        foreach ($reportList as $list) {
            if ($list['status'] == 'کارکرد') {
                self::$workingTime += $list['value'];
            } elseif ($list['status'] == 'تعطیلی') {
                self::$holidayTime += $list['value'];
            } elseif ($list['status'] == 'غیبت') {
                self::$absenceTime += $list['value'];
            } elseif ($list['status'] == 'اضافه کاری') {
                self::$overTime += $list['value'];
            } elseif ($list['status'] == 'مرخصی') {
                self::$vacationTime += $list['value'];
            }

        }
        return self::finalList();
    }

    public static function finalList ()
    {
        return collect([
            'کارکرد'=>self::$workingTime,
            'غیبت'=>self::$absenceTime,
            'اضافه کاری'=>self::$overTime,
            'تعطیلی' => self::$holidayTime,
            'مرخصی'=>self::$vacationTime
        ]);
    }




}
