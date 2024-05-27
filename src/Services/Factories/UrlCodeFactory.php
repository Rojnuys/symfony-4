<?php

namespace App\Services\Factories;

use App\Entity\UrlCode;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

class UrlCodeFactory
{
    public function __construct(protected EntityManagerInterface $em)
    {
    }


    /**
     * @throws InvalidArgumentException
     */
    public function fromArray(array $data): UrlCode
    {
        if (!isset($data['url']) || !isset($data['code'])) {
            throw new InvalidArgumentException();
        }

        $urlCode = new UrlCode($data['url'], $data['code']);
        $this->em->persist($urlCode);
        $this->em->flush();

        return $urlCode;
    }
}