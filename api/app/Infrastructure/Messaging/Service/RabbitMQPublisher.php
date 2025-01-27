<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging\Service;

use App\Core\Domain\Messaging\ValueObjects\MessageOptions;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Core\Domain\Messaging\Repository\MessagePublishInterface;
use PhpAmqpLib\Wire\AMQPTable;

/**
 * Class RabbitMQPublisher
 * @package App\Infrastructure\Persistence\RabbitMQ
 */
class RabbitMQPublisher implements MessagePublishInterface
{
    /**
     * @param AMQPStreamConnection $connection
     */
    public function __construct(private AMQPStreamConnection $connection)
    {
    }

    public function publish(string $message, MessageOptions|array $options = []): void
    {
        $messageOptions = $options instanceof MessageOptions
            ? $options
            : new MessageOptions();

        $channel = $this->createChannel();

        $this->declareExchange(
            $channel,
            $messageOptions->getExchangeName(),
            $messageOptions->getExchangeType()
        );

        if ($messageOptions->getRoutingKey()) {
            $this->declareAndBindQueue(
                $channel,
                $messageOptions->getExchangeName(),
                $messageOptions->getRoutingKey()
            );
        }

        $this->publishMessage(
            $channel,
            $message,
            $messageOptions->getExchangeName(),
            $messageOptions->getRoutingKey(),
            $messageOptions->getHeaders()
        );

        $this->closeChannel($channel);
    }
    private function declareExchange($channel, string $exchangeName, string $exchangeType): void
    {
        $channel->exchange_declare($exchangeName, $exchangeType, false, true, false);
    }

    private function declareAndBindQueue($channel, string $exchangeName, string $routingKey): void
    {
        $channel->queue_declare($routingKey, false, true, false, false);
        $channel->queue_bind($routingKey, $exchangeName, $routingKey);
    }

    private function publishMessage(
        $channel,
        string $message,
        string $exchangeName,
        string $routingKey,
        array $headers
    ): void {
        $properties = [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        ];

        if (!empty($headers)) {
            $properties['application_headers'] = new AMQPTable($headers);
        }

        $msg = new AMQPMessage($message, $properties);

        $channel->basic_publish($msg, $exchangeName, $routingKey);
    }

    /**
     * @return AMQPChannel
     */
    private function createChannel(): AMQPChannel
    {
        return $this->connection->channel();
    }

    /**
     * @param $channel
     * @return void
     */
    private function closeChannel($channel): void
    {
        $channel->close();
        $this->connection->close();
    }
}
