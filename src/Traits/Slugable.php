<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.24
 * Time: 18.19
 */
namespace App\Traits;

use App\Utils\Slugger;

trait Slugable
{
    /**
     * @return string
     */
    public function getSlug()
    {
        return Slugger::slugify($this->__toString());
    }
}
