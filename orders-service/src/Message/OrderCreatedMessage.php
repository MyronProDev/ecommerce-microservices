<?php

declare(strict_types=1);

namespace App\Message;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

final class OrderCreatedMessage implements EventMessageInterface
{
    public function __construct(
        public string $orderId,
        public Collection $orderItems,
        public string $customerEmail,
        public string $eventId,
        public DateTimeImmutable $occurredAt,
    ) {
    }
}
