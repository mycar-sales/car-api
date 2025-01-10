<?php

declare(strict_types=1);

namespace App\Core\Domain\Messaging\Repository;

/**
 * Interface MessagePublishInterface
 * @package App\Core\Domain\Enum\Repository
 */
interface MessagePublishInterface
{
    /**
     * @param string $topic
     * @param string $message
     * @param array $options
     * @return void
     */
    public function publish(string $topic, string $message, array $options = []): void;
}
