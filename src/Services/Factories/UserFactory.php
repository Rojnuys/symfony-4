<?php

namespace App\Services\Factories;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(
        protected EntityManagerInterface $em,
        protected UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function fromArray(array $data): User
    {
        if (!isset($data['email']) || !isset($data['password'])) {
            throw new \InvalidArgumentException();
        }

        $user = new User(
            $data['email'],
            $data['password'],
            $this->userPasswordHasher
        );

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}