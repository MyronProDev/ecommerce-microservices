<?php

declare(strict_types=1);

namespace App\Exception;

use Ecommerce\SharedBundle\Exception\DomainException;

final class OrderNotFoundException extends DomainException
{
    public static function withId(string $orderId): self
    {
        return new self(
            message: sprintf('Order with ID "%s" not found', $orderId),
            code: 404,
            context: ['orderId' => $orderId]
        );
    }
}
