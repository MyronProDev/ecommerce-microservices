<?php

declare(strict_types=1);

namespace App\Exception;

use Ecommerce\SharedBundle\Exception\DomainException;

final class ProductNotFoundException extends DomainException
{
    public static function withId(string $productId): self
    {
        return new self(
            message: sprintf('Product with ID "%s" not found', $productId),
            code: 404,
            context: ['productId' => $productId]
        );
    }
}
