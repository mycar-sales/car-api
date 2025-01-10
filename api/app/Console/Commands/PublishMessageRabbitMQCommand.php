<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Core\Domain\Messaging\UseCases\PublishMessageUseCase;
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

        $this->useCase->execute($exchangeName, $routingKey, $message);

        $this->info("Message published to exchange '{$exchangeName}' with routing key '{$routingKey}': {$message}");
    }
}