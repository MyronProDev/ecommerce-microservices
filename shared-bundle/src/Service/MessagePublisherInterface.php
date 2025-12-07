<?php

declare(strict_types=1);

namespace Ecommerce\SharedBundle\Service;

interface MessagePublisherInterface
{
    /**
     * Publish a message to RabbitMQ
     *
     * @param object $message The message objects to publish
     * @param array<string, mixed> $options Optional publishing options (routing key, headers, etc.)
     */
    public function publish(object $message, array $options = []): void;

    /**
     * Publish multiple messages in a batch
     *
     * @param array<object> $messages Array of message objects
     * @param array<string, mixed> $options Optional publishing options
     */
    public function publishBatch(array $messages, array $options = []): void;
}