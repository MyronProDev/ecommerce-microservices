<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\ArgumentResolver;

use Ecommerce\SharedBundle\DTO\RequestInputInterface;
use Ecommerce\SharedBundle\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RequestInputValueResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestInputInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->createFromRequest($request, $argument);
    }

    private function createFromRequest(Request $request, ArgumentMetadata $argument): RequestInputInterface
    {
        $input = $this->serializer->deserialize($request->getContent(), $argument->getType(), 'json');

        $errors = $this->validator->validate($input);
        if ($errors->count()) {
            throw new ValidationException($errors);
        }

        return $input;
    }
}