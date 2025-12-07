<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Address
{
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $name;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $street;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $city;

    #[ORM\Column(length: 32, nullable: true)]
    #[Assert\Length(max: 32)]
    private ?string $postalCode;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $country;

    public function __construct(
        ?string $name = null,
        ?string $street = null,
        ?string $city = null,
        ?string $postalCode = null,
        ?string $country = null
    ) {
        $this->name = $name;
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->country = $country ? strtoupper($country) : null;
    }

    public function getName(): ?string { return $this->name; }
    public function getStreet(): ?string { return $this->street; }
    public function getCity(): ?string { return $this->city; }
    public function getPostalCode(): ?string { return $this->postalCode; }
    public function getCountry(): ?string { return $this->country; }
}