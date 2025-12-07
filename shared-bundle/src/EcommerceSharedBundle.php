<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class EcommerceSharedBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}