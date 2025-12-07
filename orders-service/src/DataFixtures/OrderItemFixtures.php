<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Tests\Factory\OrderItemFactory;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < OrderFixtures::ORDER_COUNT; $i++) {
            /** @var \App\Entity\Order $order */
            $order = $this->getReference(OrderFixtures::ORDER_REF_PREFIX . $i, Order::class);

            $items = random_int(1, 3);
            OrderItemFactory::createMany($items, [
                'orderId' => $order,
                'quantityOrdered' => random_int(1, 5),
            ]);
        }
    }

    public function getDependencies(): array
    {
        return [OrderFixtures::class];
    }
}
