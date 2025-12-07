<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
final class OrderItem
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?Order $order;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $productId;

    #[ORM\Column]
    private ?int $quantityOrdered;


    public function __construct(
        Uuid $productId,
        int $quantityOrdered,
        Order $order = null
    ) {
        $this->productId = $productId;
        $this->quantityOrdered = $quantityOrdered;
        $this->order = $order;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getProductId(): ?Uuid
    {
        return $this->productId;
    }

    public function setProductId(Uuid $productId): static
    {
        $this->productId = $productId;

        return $this;
    }

    public function getQuantityOrdered(): ?int
    {
        return $this->quantityOrdered;
    }

    public function setQuantityOrdered(int $quantityOrdered): static
    {
        $this->quantityOrdered = $quantityOrdered;

        return $this;
    }
}
