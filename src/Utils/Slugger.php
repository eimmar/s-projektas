<?php

namespace App\Utils;

/**
 * Class Slugger
 * @package App\Utils
 */
class Slugger
{
    public static function slugify(string $string): string
    {
        return preg_replace('/\s+/', '-', mb_strtolower(trim(trim(strip_tags($string)), '.'), 'UTF-8'));
    }
}
