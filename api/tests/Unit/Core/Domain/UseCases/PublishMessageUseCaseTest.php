<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Domain\UseCases;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Messaging\UseCases\PublishMessageUseCase;
use App\Core\Domain\Messaging\Repository\MessagePublishInterface;
use App\Core\Domain\Messaging\ValueObjects\MessageOptions;
use TypeError;

class PublishMessageUseCaseTest extends TestCase
{
    public function testMessageIsPublishedSuccessfully()
    {
        $publisher = $this->createMock(MessagePublishInterface::class);
        $publisher->expects($this->once())
            ->method('publish')
            ->with('Test message', $this->isInstanceOf(MessageOptions::class));

        $useCase = new PublishMessageUseCase($publisher);
        $useCase->execute('Test message', new MessageOptions());
    }

    public function testMessageIsPublishedWithArrayOptions()
    {
        $publisher = $this->createMock(MessagePublishInterface::class);
        $publisher->expects($this->once())
            ->method('publish')
            ->with('Test message', $this->isType('array'));

        $useCase = new PublishMessageUseCase($publisher);
        $useCase->execute('Test message', ['option1' => 'value1']);
    }

    public function testNoPublisherProvided()
    {
        $this->expectException(TypeError::class);

        $useCase = new PublishMessageUseCase(new MessageOptions());
        $useCase->execute('Test message', new MessageOptions());
    }
}
