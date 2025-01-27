<?php

declare(strict_types=1);

namespace App\Core\Domain\Messaging\ValueObjects;

/**
 * Class MessageOptions
 * @package App\Core\Domain\Messaging\ValueObjects
 */
class MessageOptions
{
    /**
     * @param string $exchangeName
     * @param string $routingKey
     * @param string $exchangeType
     * @param array $headers
     */
    public function __construct(
        private string $exchangeName = 'default_exchange',
        private string $routingKey = '',
        private string $exchangeType = 'direct',
        private array $headers = []
    ) {
    }

    /**
     * @return string
     */
    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    /**
     * @return string
     */
    public function getRoutingKey(): string
    {
        return $this->routingKey;
    }

    /**
     * @return string
     */
    public function getExchangeType(): string
    {
        return $this->exchangeType;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
