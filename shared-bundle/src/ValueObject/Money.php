<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Money
{
    #[ORM\Column(type: Types::FLOAT, precision: 10, scale: 2)]
    #[Assert\Type(['type' => Types::FLOAT])]
    private float $amount;

    #[ORM\Column(type: Types::STRING, length: 3)]
    #[Assert\Type(['type' => Types::STRING])]
    #[Assert\Length(max: 3)]
    private string $currency;

    private function __construct(float $amount, string $currency = 'USD')
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative');
        }

        if ($amount > 999999.99) {
            throw new InvalidArgumentException('Money amount exceeds maximum value');
        }

        if (!in_array($currency, ['USD', 'EUR', 'GBP'], true)) {
            throw new InvalidArgumentException('Unsupported currency');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromFloat(float $amount, string $currency = 'USD'): self
    {
        return new self($amount, $currency);
    }

    public static function zero(string $currency = 'USD'): self
    {
        return new self(0.0, $currency);
    }

    public function getAmount(): float
    {
        return (float) $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(self $other): self
    {
        $this->ensureSameCurrency($other);
        return new self($this->getAmount() + $other->getAmount(), $this->currency);
    }

    public function subtract(self $other): self
    {
        $this->ensureSameCurrency($other);
        $result = $this->getAmount() - $other->getAmount();

        if ($result < 0) {
            throw new InvalidArgumentException('Cannot subtract to negative amount');
        }

        return new self($result, $this->currency);
    }

    public function multiply(int|float $multiplier): self
    {
        if ($multiplier < 0) {
            throw new InvalidArgumentException('Multiplier cannot be negative');
        }

        return new self($this->getAmount() * $multiplier, $this->currency);
    }

    public function isGreaterThan(self $other): bool
    {
        $this->ensureSameCurrency($other);
        return $this->getAmount() > $other->getAmount();
    }

    public function isGreaterThanOrEqual(self $other): bool
    {
        $this->ensureSameCurrency($other);
        return $this->getAmount() >= $other->getAmount();
    }

    public function equals(self $other): bool
    {
        return $this->currency === $other->currency
            && abs($this->getAmount() - $other->getAmount()) < 0.001;
    }

    public function format(): string
    {
        return sprintf('%s %.2f', $this->currency, $this->getAmount());
    }

    private function ensureSameCurrency(self $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException(
                sprintf('Cannot operate on different currencies: %s and %s', $this->currency, $other->currency)
            );
        }
    }
}