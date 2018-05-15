<?php

namespace App\Utils;

/**
 * Class Slugger
 * @package App\Utils
 */
class Slugger
{
    /**
     * @param string $string
     * @return string
     */
    public static function slugify(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    }
}
