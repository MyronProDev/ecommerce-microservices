<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\OrderItem;
use App\Event\OrderCreated;
use App\Message\OrderCreatedMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OrderCreated::class => 'onOrderCreated',
        ];
    }

    public function onOrderCreated(OrderCreated $event): void
    {
        $order = $event->getOrder();

        $this->messageBus->dispatch(new OrderCreatedMessage(
            orderId: $order->getId(),
            orderItems: $order->getOrderItems()->map(function (OrderItem $item) {
                return [
                    'id' => $item->getProductId(),
                    'quantity' => $item->getQuantityOrdered(),
                ];
            }),
            customerEmail: $order->getCustomerEmail(),
            eventId: $event->getEventId(),
            occurredAt: $event->getOccurredAt()
        ));
    }
}
