<?php

namespace App\Services\Shortener;

use App\Entity\UrlCode;
use App\Services\Factories\UrlCodeFactory;
use App\Url\UrlShortener\Exceptions\UrlCodeRelationNotExistException;
use App\Url\UrlShortener\Interfaces\IUrlCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ShortenerRepository implements IUrlCodeRepository
{
    protected ObjectRepository $repository;
    public function __construct(protected EntityManagerInterface $em, protected UrlCodeFactory $factory, protected Security $security)
    {
        $this->repository = $em->getRepository(UrlCode::class);
    }

    public function append(string $url, string $code): void
    {
        $this->factory->fromArray(['url' => $url, 'code' => $code]);
    }

    public function getUrl(string $code): string
    {
        $entity = $this->findOneByCriteria(['code' => $code, 'user' => $this->security->getUser()]);
        return $entity->getUrl();
    }

    public function getCode(string $url): string
    {
        return $this->findOneByCriteria(['url' => $url, 'user' => $this->security->getUser()])->getCode();
    }

    /**
     * @throws UrlCodeRelationNotExistException
     */
    protected function findOneByCriteria(array $criteria): UrlCode
    {
        $entity = $this->repository->findOneBy($criteria);

        if (is_null($entity)) {
            throw new UrlCodeRelationNotExistException();
        }

        return $entity;
    }
}