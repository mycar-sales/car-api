<?php

declare(strict_types=1);

namespace App\Infrastructure\Messaging\Service;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Core\Domain\Messaging\Repository\MessagePublishInterface;

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

    /**
     * @param string $exchangeName
     * @param string $message
     * @param array $headers
     * @return void
     */
    public function publish(string $exchangeName, string $message, array $headers = []): void
    {
        $channel = $this->createChannel();

        $channel->exchange_declare($exchangeName, 'fanout', false, true, false);

        // Declara a exchange (direct)
        $channel->exchange_declare($exchangeName, 'fanout', false, true, false);

        // Declara a fila (opcional, mas recomendado)
        $queueName = "order-created"; // A fila terá o mesmo nome da routing key
        $channel->queue_declare($queueName, false, true, false, false);

        // Vincula a fila à exchange
        $channel->queue_bind($queueName, $exchangeName, $queueName);

        // Cria a mensagem
        $msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

        // Publica na exchange
        $channel->basic_publish($msg, $exchangeName, $queueName);

        $this->closeChannel($channel);
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
