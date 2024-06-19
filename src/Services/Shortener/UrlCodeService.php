<?php

namespace App\Services\Shortener;

use App\Entity\UrlCode;
use App\Repository\UrlCodeRepository;
use App\Services\PaginatorService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

class UrlCodeService
{

    public function __construct(
        protected EntityManagerInterface $em,
        protected UrlCodeRepository $repository,
        protected UrlCodeQueryService $urlCodeQueryService,
        protected PaginatorService $paginatorService
    )
    {
    }

    public function getAllByUser(): array
    {
        return $this->repository->findAll();
    }

    public function getAllByUserWithPaginate(int $page, int $limit): PaginationInterface
    {
        return $this->paginatorService->getPaginator(
            $this->urlCodeQueryService->createQueryFindAllByUser(),
            $page,
            $limit
        );
    }

    public function incrementStatistic(UrlCode $urlCode): void
    {
        $urlCode->incrementCount();
        $this->em->persist($urlCode);
        $this->em->flush();
    }
}