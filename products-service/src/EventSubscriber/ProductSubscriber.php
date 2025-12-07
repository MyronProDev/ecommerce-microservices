<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\ProductCreated;
use App\Message\ProductCreatedMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductCreated::class => 'onProductCreated',
        ];
    }

    public function onProductCreated(ProductCreated $event): void
    {
        $product = $event->getProduct();

        $this->messageBus->dispatch(new ProductCreatedMessage(
            $product->getName(),
            $product->getQuantity()->getQuantity(),
            $product->getPrice()->getAmount(),
            $product->getPrice()->getCurrency(),
            $product->getSku()
        ));
    }
}
