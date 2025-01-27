<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Core\Domain\Messaging\UseCases\PublishMessageUseCase;
use App\Core\Domain\Messaging\ValueObjects\MessageOptions;
use Illuminate\Console\Command;

class PublishMessageRabbitMQCommand extends Command
{
    protected $signature = 'rabbitmq:publish {exchange} {routingKey} {message}';
    protected $description = 'Publish a message to RabbitMQ using an exchange';

    private PublishMessageUseCase $useCase;

    public function __construct(PublishMessageUseCase $useCase)
    {
        parent::__construct();
        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $exchangeName = $this->argument('exchange');
        $routingKey = $this->argument('routingKey');
        $message = $this->argument('message');

        $messageOptions = new MessageOptions(
            exchangeName: $exchangeName,
            routingKey: $routingKey,
            exchangeType: 'fanout',
            headers: ['priority' => 1]
        );


        $this->useCase->execute($message, $messageOptions);

        $this->info("Message published to exchange '{$exchangeName}' with routing key '{$routingKey}': {$message}");
    }
}
