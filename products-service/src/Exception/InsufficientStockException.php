<?php

declare(strict_types=1);

namespace App\Exception;

use Ecommerce\SharedBundle\Exception\DomainException;
use Symfony\Component\HttpFoundation\Response;

final class InsufficientStockException extends DomainException
{
    public static function forProduct(string $productId, int $requested, int $available): self
    {
        return new self(
            message: sprintf(
                'Insufficient stock for product "%s". Requested: %d, Available: %d',
                $productId,
                $requested,
                $available
            ),
            code: Response::HTTP_CONFLICT,
            context: [
                'productId' => $productId,
                'requested' => $requested,
                'available' => $available,
            ]
        );
    }
}
