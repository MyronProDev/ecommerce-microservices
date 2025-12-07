<?php

declare(strict_types=1);

namespace App\DTO;

use Ecommerce\SharedBundle\DTO\RequestInputInterface;
use Ecommerce\SharedBundle\ValueObject\Address;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrderRequest implements RequestInputInterface
{
    #[Assert\NotBlank]
    private string $customerEmail;
    #[Assert\NotBlank]
    #[Assert\All(constraints: [
       new Assert\Collection(fields: [
           'id' => [
               new Assert\Uuid()
           ],
           'quantity' => [
               new Assert\Positive()
           ]
       ])
    ])]
    private array $products;

    #[Assert\NotNull]
    #[Assert\Valid]
    private Address $billingAddress;

    #[Assert\NotNull]
    #[Assert\Valid]
    private Address $shippingAddress;

    public function getCustomerEmail(): string
    {
        return $this->customerEmail;
    }
    public function setCustomerEmail(string $email): void
    {
        $this->customerEmail = $email;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }
    public function setBillingAddress(array $addr): void
    {
        $this->billingAddress = new Address(
            $addr['name'],
            $addr['street'],
            $addr['city'],
            $addr['postalCode'],
            $addr['country']
        );
    }

    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }
    public function setShippingAddress(array $addr): void
    {
        $this->shippingAddress = new Address(
            $addr['name'],
            $addr['street'],
            $addr['city'],
            $addr['postalCode'],
            $addr['country']
        );
    }
}
