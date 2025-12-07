<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationException extends HttpException implements ExceptionInterface
{
    private ConstraintViolationListInterface $violationList;

    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;

        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}