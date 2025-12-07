<?php

declare(strict_types=1);

namespace App\DTO;

use Ecommerce\SharedBundle\DTO\RequestInputInterface;
use Ecommerce\SharedBundle\ValueObject\Money;
use Ecommerce\SharedBundle\ValueObject\Quantity;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateProductRequest implements RequestInputInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private string $name;

    #[Assert\NotNull]
    #[Assert\Valid]
    private Money $price;

    #[Assert\NotNull]
    #[Assert\Valid]
    private Quantity $quantity;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 32)]
    private string $sku;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): Quantity
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = Quantity::fromInt($quantity);
        return $this;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(array $price): self
    {
        $this->price = Money::fromFloat($price['amount'], $price['currency']);

        return $this;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }
}
