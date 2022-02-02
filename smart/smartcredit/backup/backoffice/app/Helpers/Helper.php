<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function shout($string)
    {
        return strtoupper($string);
    }
}