<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Tests\Factory\OrderFactory;

class OrderFixtures extends Fixture
{
    public const ORDER_REF_PREFIX = 'order_';
    public const ORDER_COUNT = 5;

    public function load(ObjectManager $manager): void
    {
        foreach (OrderFactory::createMany(self::ORDER_COUNT) as $i => $order) {
            $this->addReference(self::ORDER_REF_PREFIX . $i, $order);
        }
    }
}
