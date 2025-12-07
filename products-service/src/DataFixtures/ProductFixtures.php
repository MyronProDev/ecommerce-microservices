<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Tests\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        ProductFactory::createMany(self::PRODUCT_COUNT);
    }
}
