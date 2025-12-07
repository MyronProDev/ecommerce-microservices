<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;

final class OrderProvider
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }

    public function getById(string $id): ?Order
    {
        return $this->orderRepository->find($id);
    }

    public function getAll(): array
    {
        return $this->orderRepository->findAll();
    }
}
