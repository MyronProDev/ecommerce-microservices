<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Order;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class OrderCreated
{
    public function __construct(
        private readonly Order $order,
        private ?string $eventId = null,
        private ?DateTimeImmutable $occurredAt = null,
    ) {
        $this->eventId = Uuid::v4()->toRfc4122();
        $this->occurredAt = new DateTimeImmutable();
    }

    public function getOrder(): Order
    {
        return $this->order;
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
