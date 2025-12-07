<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreateProductRequest;
use App\Event\ProductCreated;
use App\Service\ProductManager;
use App\Service\ProductProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ProductProvider $productProvider,
        private readonly ProductManager $productManager,
        private readonly EntityManagerInterface $entityManager,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    #[Route('/api/products', name: 'products.create', methods: ['POST'])]
    public function create(CreateProductRequest $input): JsonResponse
    {
        $product = $this->productManager->createProduct(
            $input->getName(),
            $input->getPrice(),
            $input->getQuantity(),
            $input->getSku()
        );

        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new ProductCreated($product));

        return $this->json($product, Response::HTTP_CREATED);
    }

    #[Route('/api/products', name: 'products.getAll', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $products = $this->productProvider->getAll();

        return $this->json($products);
    }

    #[Route('/api/products/{id}', name: 'products.get', methods: ['GET'])]
    public function getOneById(string $id): JsonResponse
    {
        $product = $this->productProvider->getById($id);

        return $this->json($product);
    }
}
