<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Ecommerce\SharedBundle\ValueObject\Money;
use Ecommerce\SharedBundle\ValueObject\Quantity;

final class ProductFactory
{
    public function create(
        string $name,
        Money $price,
        Quantity $quantity,
        string $sku
    ): Product {
        return new Product(
            $name,
            $price,
            $quantity,
            $sku
        );
    }
}
