<?php

declare(strict_types=1);

namespace App\Core\Domain\Messaging\Repository;

use App\Core\Domain\Messaging\ValueObjects\MessageOptions;

/**
 * Interface MessagePublishInterface
 * @package App\Core\Domain\Enum\Repository
 */
interface MessagePublishInterface
{
    /**
     * @param string $message
     * @param MessageOptions|array $options
     * @return void
     */
    public function publish(string $message, MessageOptions|array $options = []): void;
}
