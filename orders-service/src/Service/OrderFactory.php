<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Enum\OrderStatus;
use Ecommerce\SharedBundle\ValueObject\Address;

final class OrderFactory
{
    /**
     * @param string $customerEmail
     * @param OrderItem[] $orderItems
     * @param Address $billingAddress
     * @param Address $shippingAddress
     * @return Order
     */
    public function create(
        string $customerEmail,
        array $orderItems,
        Address $billingAddress,
        Address $shippingAddress
    ): Order {
        $order = (new Order())
            ->setCustomerEmail($customerEmail)
            ->setStatus(OrderStatus::PENDING)
            ->setBillingAddress($billingAddress)
            ->setShippingAddress($shippingAddress)
        ;

        foreach ($orderItems as $orderItem) {
            $orderItem->setOrder($order);
            $order->addOrderItem($orderItem);
        }

        return $order;
    }
}
