<?php


namespace App\Helpers;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class DateFormat
{

    public static function toJalali($date)  // : timestamp
    {
        return Verta::instance($date);
    }

    public static function convertToJalali($date)
    {
        if ($date == null)
            return;

        return Verta::instance($date);
    }

    public static function toMiladi($date)
    {
            $date = $date ?? Verta::now();
            $var = Verta::parse($date);
            return trim(Carbon::parse($var->DateTime()->format('Y-m-d H:i:s')));
    }

}
