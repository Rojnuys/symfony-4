<?php

namespace App\Repository;

use App\Entity\UrlCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * @extends ServiceEntityRepository<UrlCode>
 */
class UrlCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, protected Security $security)
    {
        parent::__construct($registry, UrlCode::class);
    }

    public function findAll(): array
    {
        return $this->findBy(['user' => $this->security->getUser()]);
    }
}
