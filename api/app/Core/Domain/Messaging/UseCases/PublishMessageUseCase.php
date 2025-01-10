<?php

declare(strict_types=1);

namespace App\Core\Domain\Messaging\UseCases;

use App\Core\Domain\Messaging\Repository\MessagePublishInterface;

/**
 * Class PublishMessageUseCase
 * @package App\Core\Domain\Messaging\UseCases
 */
class PublishMessageUseCase
{
    /**
     * @param MessagePublishInterface $publisher
     */
    public function __construct(private MessagePublishInterface $publisher)
    {
    }

    /**
     * @param string $topic
     * @param string $message
     * @return void
     */
    public function execute(string $topic, string $message): void
    {
        $this->publisher->publish($topic, $message);
    }
}
