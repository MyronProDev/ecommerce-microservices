<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Product;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class ProductCreated
{
    public function __construct(
        private readonly Product $product,
        private ?string $eventId = null,
        private ?DateTimeImmutable $occurredAt = null,
    ) {
        $this->eventId = Uuid::v6()->toRfc4122();
        $this->occurredAt = new DateTimeImmutable();
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getOccurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
