<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\Exception;

use Exception;
use Throwable;

abstract class DomainException extends Exception implements ExceptionInterface
{
    public function __construct(
        string                 $message = '',
        int                    $code = 0,
        ?Throwable             $previous = null,
        private readonly array $context = []
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
