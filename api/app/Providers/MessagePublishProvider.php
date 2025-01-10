<?php

namespace App\Providers;

use App\Core\Domain\Messaging\UseCases\PublishMessageUseCase;
use RuntimeException;
use Aws\Sqs\SqsClient;
use RdKafka\Producer as KafkaProducer;
use Illuminate\Support\ServiceProvider;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Core\Domain\Messaging\Repository\MessagePublishInterface;
use App\Infrastructure\Messaging\Service\RabbitMQPublisher;

/**
 * Class MessagePublishProvider
 * @package App\Providers
 */
class MessagePublishProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            PublishMessageUseCase::class,
            PublishMessageUseCase::class
        );
        $this->app->singleton(
            MessagePublishInterface::class,
            function () {
                $driver = config('messaging.driver');
                return match ($driver) {
                    'rabbitmq' => $this->createRabbitMQPublisher(),
                    'kafka' => $this->createKafkaPublisher(),
                    'sqs' => $this->createSQSPublisher(),
                    default => throw new RuntimeException("Unsupported messaging driver: {$driver}"),
                };
            }
        );
    }

    private function createRabbitMQPublisher(): RabbitMQPublisher
    {
        $config = config('messaging.rabbitmq');

        $connection = new AMQPStreamConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password']
        );

        return new RabbitMQPublisher($connection);
    }

    private function createKafkaPublisher(): KafkaPublisher
    {
        $config = config('messaging.kafka');
        $producer = new KafkaProducer();
        $producer->addBrokers($config['brokers']);

        return new KafkaPublisher($producer);
    }

    private function createSQSPublisher(): SQSPublisher
    {
        $config = config('messaging.sqs');

        $client = new SqsClient(
            [
            'region' => $config['region'],
            'version' => 'latest',
            'credentials' => [
                'key' => $config['key'],
                'secret' => $config['secret'],
            ],
            ]
        );

        return new SQSPublisher($client);
    }
}
