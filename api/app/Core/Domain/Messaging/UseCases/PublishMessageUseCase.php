<?php

declare(strict_types=1);

namespace App\Core\Domain\Messaging\UseCases;

use App\Core\Domain\Messaging\Repository\MessagePublishInterface;
use App\Core\Domain\Messaging\ValueObjects\MessageOptions;

/**
 * Class PublishMessageUseCase
 * @package App\Core\Domain\Messaging\UseCases
 */
class PublishMessageUseCase
{
    /**
     * @param MessagePublishInterface|null $publisher
     */
    public function __construct(private ?MessagePublishInterface $publisher)
    {
    }

    /**
     * @param string $message
     * @param MessageOptions|array $options
     * @return void
     */
    public function execute(string $message, MessageOptions|array $options = []): void
    {
        $this->publisher->publish($message, $options);
    }
}
