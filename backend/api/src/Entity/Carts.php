<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CartsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartsRepository::class)]
#[ApiResource]
class Carts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?users $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?products $product_id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?users
    {
        return $this->user_id;
    }

    public function setUserId(?users $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getProductId(): ?products
    {
        return $this->product_id;
    }

    public function setProductId(?products $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
