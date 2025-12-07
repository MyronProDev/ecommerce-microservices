<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Ecommerce\SharedBundle\ValueObject\Money;
use Ecommerce\SharedBundle\ValueObject\Quantity;

final class ProductManager
{
    public function __construct(
        private readonly ProductFactory $productFactory
    ) {
    }

    public function createProduct(
        string $name,
        Money $price,
        Quantity $quantity,
        string $sku
    ): Product {
        return $this->productFactory->create($name, $price, $quantity, $sku);
    }
}
