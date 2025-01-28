<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\ValueObjects;

use App\Core\Domain\Messaging\ValueObjects\MessageOptions;
use Tests\TestCase;

class MessageOptionsTest extends TestCase
{
    public function testExchangeNameIsSetCorrectly()
    {
        $options = new MessageOptions('my_exchange');
        $this->assertEquals('my_exchange', $options->getExchangeName());
    }

    public function testRoutingKeyIsSetCorrectly()
    {
        $options = new MessageOptions('default_exchange', 'my_routing_key');
        $this->assertEquals('my_routing_key', $options->getRoutingKey());
    }

    public function testExchangeTypeIsSetCorrectly()
    {
        $options = new MessageOptions('default_exchange', '', 'topic');
        $this->assertEquals('topic', $options->getExchangeType());
    }

    public function testHeadersAreSetCorrectly()
    {
        $headers = ['header1' => 'value1'];
        $options = new MessageOptions('default_exchange', '', 'direct', $headers);
        $this->assertEquals($headers, $options->getHeaders());
    }

    public function testDefaultValuesAreSetCorrectly()
    {
        $options = new MessageOptions();
        $this->assertEquals('default_exchange', $options->getExchangeName());
        $this->assertEquals('', $options->getRoutingKey());
        $this->assertEquals('direct', $options->getExchangeType());
        $this->assertEquals([], $options->getHeaders());
    }
}
