<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Product;
use Ecommerce\SharedBundle\ValueObject\Money;
use Ecommerce\SharedBundle\ValueObject\Quantity;
use Override;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Product>
 */
final class ProductFactory extends PersistentObjectFactory
{
    #[Override]
    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[Override]
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->words(3, true),
            'price' => Money::fromFloat(self::faker()->randomFloat(2, 1, 9999), 'USD'),
            'quantity' => Quantity::fromInt(self::faker()->numberBetween(0, 1000)),
            'sku' => strtoupper(self::faker()->bothify('SKU-#####')),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Product $product): void {})
            ;
    }
}
