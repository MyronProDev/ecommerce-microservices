<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Embeddable]
final class Quantity
{
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private int $quantity;

    private function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Quantity cannot be negative');
        }

        if ($value > 1_000_000) {
            throw new InvalidArgumentException('Quantity exceeds maximum allowed value');
        }

        $this->quantity = $value;
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function add(self $other): self
    {
        return new self($this->quantity + $other->quantity);
    }

    public function subtract(self $other): self
    {
        $result = $this->quantity - $other->quantity;

        if ($result < 0) {
            throw new InvalidArgumentException(
                sprintf('Cannot subtract %d from %d - result would be negative', $other->quantity, $this->quantity)
            );
        }

        return new self($result);
    }

    public function multiply(int $multiplier): self
    {
        if ($multiplier < 0) {
            throw new InvalidArgumentException('Multiplier cannot be negative');
        }

        return new self($this->quantity * $multiplier);
    }

    public function isGreaterThan(self $other): bool
    {
        return $this->quantity > $other->quantity;
    }

    public function isGreaterThanOrEqual(self $other): bool
    {
        return $this->quantity >= $other->quantity;
    }

    public function isLessThan(self $other): bool
    {
        return $this->quantity < $other->quantity;
    }

    public function isLessThanOrEqual(self $other): bool
    {
        return $this->quantity <= $other->quantity;
    }

    public function equals(self $other): bool
    {
        return $this->quantity === $other->quantity;
    }

    #[Ignore]
    public function isZero(): bool
    {
        return $this->quantity === 0;
    }

    #[Ignore]
    public function isPositive(): bool
    {
        return $this->quantity > 0;
    }
}