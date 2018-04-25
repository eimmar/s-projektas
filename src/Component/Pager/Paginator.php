<?php
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.25
 * Time: 00.49
 */
namespace App\Component\Pager;

use Knp\Component\Pager\Paginator as KnpPaginator;

class Paginator extends KnpPaginator
{
    public function paginate($target, $page = 1, $limit = 10, array $options = array())
    {
        /** @var \Knp\Component\Pager\Pagination\AbstractPagination $paginated */
        $paginated = parent::paginate($target, $page, $limit, $options);

        $cleanedItems = array_map(function ($item) {
            return is_array($item) ? $item[0] : $item;
        }, $paginated->getItems());

        $paginated->setItems($cleanedItems);

        return $paginated;
    }
}
