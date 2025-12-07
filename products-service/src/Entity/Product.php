<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ecommerce\SharedBundle\Trait\ProductStockTrait;
use Ecommerce\SharedBundle\ValueObject\Money;
use Ecommerce\SharedBundle\ValueObject\Quantity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
final class Product
{
    use TimestampableEntity;
    use ProductStockTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Embedded(class: Money::class, columnPrefix: false)]
    private Money $price;

    #[ORM\Embedded(class: Quantity::class, columnPrefix: false)]
    private Quantity $quantity;

    #[ORM\Column(type: 'string', length: 32)]
    private ?string $sku;

    public function __construct(
        string $name,
        Money $price,
        Quantity $quantity,
        string $sku
    ) {
        $this->id = Uuid::v6();
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->sku = $sku;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function setQuantity(Quantity $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;
        return $this;
    }
}
