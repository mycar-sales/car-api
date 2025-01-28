<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Service;

use App\Infrastructure\Messaging\Service\RabbitMQPublisher;
use App\Core\Domain\Messaging\ValueObjects\MessageOptions;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use PHPUnit\Framework\TestCase;

class RabbitMQPublisherTest extends TestCase
{
    public function testMessageIsPublishedSuccessfully()
    {
        $connection = $this->createMock(AMQPStreamConnection::class);
        $channel = $this->createMock(AMQPChannel::class);

        $connection->method('channel')->willReturn($channel);

        $channel->expects($this->once())
            ->method('exchange_declare')
            ->with('default_exchange', 'direct', false, true, false);

        $channel->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->isInstanceOf(AMQPMessage::class),
                'default_exchange',
                ''
            );

        $publisher = new RabbitMQPublisher($connection);
        $publisher->publish('Test message', new MessageOptions());
    }

    public function testMessageIsPublishedWithRoutingKey()
    {
        $connection = $this->createMock(AMQPStreamConnection::class);
        $channel = $this->createMock(AMQPChannel::class);

        $connection->method('channel')->willReturn($channel);

        $channel->expects($this->once())
            ->method('exchange_declare')
            ->with('default_exchange', 'direct', false, true, false);

        $channel->expects($this->once())
            ->method('queue_declare')
            ->with('my_routing_key', false, true, false, false);

        $channel->expects($this->once())
            ->method('queue_bind')
            ->with('my_routing_key', 'default_exchange', 'my_routing_key');

        $channel->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->isInstanceOf(AMQPMessage::class),
                'default_exchange',
                'my_routing_key'
            );

        $publisher = new RabbitMQPublisher($connection);
        $publisher->publish('Test message', new MessageOptions('default_exchange', 'my_routing_key'));
    }

    public function testMessageIsPublishedWithHeaders()
    {
        $connection = $this->createMock(AMQPStreamConnection::class);
        $channel = $this->createMock(AMQPChannel::class);

        $connection->method('channel')->willReturn($channel);

        $channel->expects($this->once())
            ->method('exchange_declare')
            ->with('default_exchange', 'direct', false, true, false);

        $channel->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->callback(
                    function (AMQPMessage $msg) {
                        $properties = $msg->get_properties();
                        return isset($properties['application_headers']) &&
                        $properties['application_headers'] instanceof AMQPTable &&
                        $properties['application_headers']->getNativeData() === ['header1' => 'value1'];
                    }
                ),
                'default_exchange',
                ''
            );

        $publisher = new RabbitMQPublisher($connection);
        $publisher->publish(
            'Test message',
            new MessageOptions(
                'default_exchange',
                '',
                'direct',
                ['header1' => 'value1']
            )
        );
    }

    public function testChannelIsClosedAfterPublishing()
    {
        $connection = $this->createMock(AMQPStreamConnection::class);
        $channel = $this->createMock(AMQPChannel::class);

        $connection->method('channel')->willReturn($channel);

        $channel->expects($this->once())
            ->method('close');

        $connection->expects($this->once())
            ->method('close');

        $publisher = new RabbitMQPublisher($connection);
        $publisher->publish('Test message', new MessageOptions());
    }

    public function testMessageIsPublishedWithArrayOptions()
    {
        $connection = $this->createMock(AMQPStreamConnection::class);
        $channel = $this->createMock(AMQPChannel::class);

        $connection->method('channel')->willReturn($channel);

        $channel->expects($this->once())
            ->method('exchange_declare')
            ->with('default_exchange', 'direct', false, true, false);

        $channel->expects($this->once())
            ->method('basic_publish')
            ->with(
                $this->isInstanceOf(AMQPMessage::class),
                'default_exchange',
                ''
            );

        $publisher = new RabbitMQPublisher($connection);
        $publisher->publish('Test message', ['exchangeName' => 'default_exchange']);
    }
}
