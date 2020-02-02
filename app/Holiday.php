<?php

namespace App;

use App\Helpers\DateFormat;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    protected $guarded = [];

    public function isDaily()
    {
        if ($this->is_daily == 1)
            return 1;
        else
            return 0;
    }

    public static function data($request)
    {
        return [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'is_daily' => $request->get('is_daily'),
            'start' => DateFormat::toMiladi($request->get('start')),
            'end' => DateFormat::toMiladi($request->get('end')),
        ];

    }
}
