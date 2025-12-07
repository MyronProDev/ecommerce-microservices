<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

final class ProductProvider
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function getAll(): array
    {
        return $this->productRepository->findAll();
    }

    public function getById(string $id): ?Product
    {
        return $this->productRepository->find($id);
    }
}
