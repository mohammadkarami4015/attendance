<?php


namespace App\Helper;


class message
{
    public static function show($message)
    {
        session()->flash('flash_message', $message);
    }

}
