<?php

namespace App\Entity;

use App\Repository\UrlCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrlCodeRepository::class)]
class UrlCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $count = 0;

    public function __construct(
        #[ORM\Column(length: 255)]
        private string $url,
        #[ORM\Column(length: 10)]
        private string $code,
        #[ORM\ManyToOne(targetEntity: User::class, fetch: 'LAZY', inversedBy: 'user')]
        #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
        private User $user
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function incrementCount(): static
    {
        $this->count++;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
