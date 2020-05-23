<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    public static function amount($amount)
    {
        return number_format($amount, 2, '.', ' ');
    }

    public static function date($date)
    {
        return date('d.m.Y', strtotime($date));
    }
}
