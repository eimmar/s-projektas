<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.25
 * Time: 22.29
 */

namespace App\Utils;


class Search
{
    /**
     * @var string|null
     */
    private $search;

    /**
     * @return string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param string $search
     * @return Search
     */
    public function setSearch(?string $search): Search
    {
        $this->search = $search;
        return $this;
    }
}
