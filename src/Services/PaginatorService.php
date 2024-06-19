<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PaginatorService
{

    public function __construct(
        protected EntityManagerInterface $em,
        protected PaginatorInterface $paginator
    )
    {
    }

    public function getPaginator(Query $query, int $page, int $pageSize): PaginationInterface
    {
        return $this->paginator->paginate(
            $query,
            max($page, 1),
            max($pageSize, 1)
        );
    }
}