<?php

declare(strict_types=1);

namespace App\Message;

class ProductCreatedMessage implements EventMessageInterface
{
    public function __construct(
        private string $name,
        private int $quantity,
        private float $price,
        private string $currency,
        private string $sku
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSku(): string
    {
        return $this->sku;
    }


}
