<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CreateOrderRequest;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

final class OrderManager
{
    public function __construct(
        private readonly OrderFactory $orderFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createOrder(CreateOrderRequest $orderDTO): Order
    {
        $orderItems = array_map(function (array $product) {
            $orderItem = new OrderItem(Uuid::fromString($product['id']), $product['quantity']);
            $this->entityManager->persist($orderItem);
            return $orderItem;
        }, $orderDTO->getProducts());

        $order = $this->orderFactory->create(
            $orderDTO->getCustomerEmail(),
            $orderItems,
            $orderDTO->getBillingAddress(),
            $orderDTO->getShippingAddress()
        );

        $this->entityManager->persist($order);

        return $order;
    }
}
