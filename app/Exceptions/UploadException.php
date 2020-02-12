<?php

namespace App\Exceptions;

use Exception;

class UploadException extends Exception
{
    public function render()
    {
        Return response()->view('layouts.exception', [
            'msg' =>  Exception::getMessage(),
            'code' => Exception::getCode(),
        ]);
    }
}
