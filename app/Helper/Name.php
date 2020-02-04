<?php


namespace App\Helpers;

use App\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

class Name
{

    public static function userFullName(User $user)
    {

        return $user->name . " " . $user->family;
    }

}
