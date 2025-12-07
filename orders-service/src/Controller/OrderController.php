<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreateOrderRequest;
use App\Event\OrderCreated;
use App\Service\OrderManager;
use App\Service\OrderProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(
        private readonly OrderProvider $orderProvider,
        private readonly OrderManager $orderManager,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    #[Route('/api/orders', name: 'orders.create', methods: ['POST'])]
    public function createOrder(CreateOrderRequest $input): JsonResponse
    {
        $order = $this->orderManager->createOrder($input);

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new OrderCreated($order));

        return $this->json($order, Response::HTTP_CREATED);
    }

    #[Route('/api/orders/{id}', name: 'orders.get', methods: ['GET'])]
    public function getOneById(string $id): JsonResponse
    {
        $order = $this->orderProvider->getById($id);

        return $this->json($order);
    }

    #[Route('/api/orders', name: 'orders.getAll', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $orders = $this->orderProvider->getAll();

        return $this->json($orders);
    }
}
