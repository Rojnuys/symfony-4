<?php

namespace App\Services\Shortener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Bundle\SecurityBundle\Security;

class UrlCodeQueryService
{

    public function __construct(
        protected EntityManagerInterface $em,
        protected Security $security
    )
    {
    }

    public function createQueryFindAllByUser(): Query
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from('App\Entity\UrlCode', 'u')
            ->where('u.user = :user')
            ->orderBy('u.id', 'DESC')
            ->setParameter('user', $this->security->getUser())
            ->getQuery();
    }
}