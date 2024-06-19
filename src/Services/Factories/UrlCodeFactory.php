<?php

namespace App\Services\Factories;

use App\Entity\UrlCode;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bundle\SecurityBundle\Security;

class UrlCodeFactory
{
    public function __construct(protected EntityManagerInterface $em, protected Security $security)
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

        /**
         * @var User $user
         */
        $user = $this->security->getUser();

        $urlCode = new UrlCode($data['url'], $data['code'], $user);
        $this->em->persist($urlCode);
        $this->em->flush();

        return $urlCode;
    }
}