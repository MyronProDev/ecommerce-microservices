<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\Trait;

use InvalidArgumentException;
use Ecommerce\SharedBundle\ValueObject\Quantity;
use Symfony\Component\Serializer\Attribute\Ignore;

trait ProductStockTrait
{
    /**
     * Check if the product has enough stocks
     */
    public function hasEnoughStock(Quantity $requested): bool
    {
        return $this->quantity->isGreaterThanOrEqual($requested);
    }

    /**
     * Reduce stock quantity
     * @throws InvalidArgumentException if insufficient stock
     */
    public function reduceStock(Quantity $amount): void
    {
        if (!$this->hasEnoughStock($amount)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Insufficient stock. Requested: %d, Available: %d',
                    $amount->getValue(),
                    $this->quantity->getValue()
                )
            );
        }

        $this->quantity = $this->quantity->subtract($amount);
    }

    /**
     * Increase stock quantity
     */
    public function increaseStock(Quantity $amount): void
    {
        $this->quantity = $this->quantity->add($amount);
    }

    /**
     * Set stock quantity directly
     */
    public function setQuantity(Quantity $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Check if a product is out of stock
     */
    #[Ignore]
    public function isOutOfStock(): bool
    {
        return $this->quantity->isZero();
    }

    /**
     * Check if stock is low (less than a threshold)
     */
    #[Ignore]
    public function isLowStock(int $threshold = 10): bool
    {
        return $this->quantity->isLessThan(Quantity::fromInt($threshold));
    }
}
