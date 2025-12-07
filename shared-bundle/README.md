# Ecommerce Shared Bundle

Shared Symfony bundle for Product and Order microservices.

## Features

- **BaseProduct Entity**: MappedSuperclass with common product fields
- **Value Objects**: Money and Quantity with validation
- **DTOs**: ProductDTO and OrderDTO with validation groups
- **Messages**: Domain messages for RabbitMQ communication
- **Exceptions**: Custom domain exceptions with context
- **Interfaces**: MessagePublisher interface for DI
- **Serializer**: Custom message serializer for RabbitMQ

## Installation

### 1. Add to composer.json (local development)

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../ecommerce-shared-bundle"
        }
    ],
    "require": {
        "ecommerce/shared-bundle": "@dev"
    }
}
```

### 2. Install the bundle

```bash
composer require ecommerce/shared-bundle
```

### 3. Register the bundle (if not auto-registered)

```php
// config/bundles.php
return [
    // ...
    Ecommerce\SharedBundle\EcommerceSharedBundle::class => ['all' => true],
];
```

## Usage

### Product Entity

```php
use Ecommerce\SharedBundle\Entity\BaseProduct;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product extends BaseProduct
{
    // Add service-specific fields if needed
}
```

### Value Objects

```php
use ValueObject\Money;use ValueObject\Quantity;

$price = Money::fromFloat(12.99);
$quantity = Quantity::fromInt(100);

$product = new Product(
    name: 'Coffee Mug',
    price: $price,
    quantity: $quantity
);

// Business logic in entities
if ($product->hasEnoughStock(Quantity::fromInt(5))) {
    $product->reduceStock(Quantity::fromInt(5));
}
```

### DTOs with Validation

```php
use Ecommerce\SharedBundle\DTO\ProductDTO;
use Symfony\Component\Validator\Validator\ValidatorInterface;

$dto = ProductDTO::fromArray($request->toArray());

$errors = $validator->validate($dto, groups: ['create']);
```

### Publishing Messages

```php
use Ecommerce\SharedBundle\Message\ProductCreatedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

$message = new ProductCreatedMessage(
    productId: $product->getId()->toRfc4122(),
    name: $product->getName(),
    price: $product->getPrice()->getAmount(),
    quantity: $product->getQuantity()->getValue(),
    messageId: Uuid::v4()->toRfc4122()
);

$messageBus->dispatch($message);
```

### Handling Messages

```php
use Ecommerce\SharedBundle\Message\ProductCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductCreatedHandler
{
    public function __invoke(ProductCreatedMessage $message): void
    {
        // Handle product creation in Order Service
        // Create or update local product copy
    }
}
```

### Custom Exceptions

```php
use Ecommerce\SharedBundle\Exception\InsufficientStockException;
use Ecommerce\SharedBundle\Exception\ProductNotFoundException;

if (!$product) {
    throw ProductNotFoundException::withId($productId);
}

if (!$product->hasEnoughStock($requestedQuantity)) {
    throw InsufficientStockException::forProduct(
        $productId,
        $requestedQuantity->getValue(),
        $product->getQuantity()->getValue()
    );
}
```

## Architecture Benefits

- **DRY Principle**: Shared code between services
- **Type Safety**: PHP 8.4 readonly properties
- **Validation**: Built-in validation with groups
- **Domain Logic**: Encapsulated in value objects and entities
- **Messaging**: Standardized message format
- **Testability**: Interface-driven design

## Testing

```bash
composer test
```

## Requirements

- PHP >= 8.4
- Symfony >= 6.4
- Doctrine ORM >= 2.17

## License

MIT