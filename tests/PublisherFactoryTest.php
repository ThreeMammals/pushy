<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class PublisherFactoryTests extends TestCase
{
    private $path;
    private $publisherFactory;

    public function setUp()
    {
        $this->path = 'test_file_publisher';
        $this->publisherFactory = new \Pushy\PublisherFactory(new \Pushy\UUIDProvider());
    }

    public function testShouldReturnFilePublisher(): void
    {
        $type = 'FilePublisher';
        $config = (object) ['type' => $type, 'location' => $this->path];
        $publisher = $this->publisherFactory->get($config);
        $this->assertInstanceOf('\Pushy\FilePublisher', $publisher);
    }

    public function testShouldReturnSnsPublisher(): void
    {
        $type = 'SNSPublisher';
        $config = (object) ['type' => $type, 'location' => $this->path];
        $publisher = $this->publisherFactory->get($config);
        $this->assertInstanceOf('\Pushy\SNSPublisher', $publisher);
    }

    public function testShouldReturnAmqpPublisher(): void
    {
        $type = 'AMQPPublisher';
        $config = (object) ['type' => $type, 'location' => 'localhost'];
        // todo mock AMQP?
        $publisher = $this->publisherFactory->get($config);
        $this->assertInstanceOf('\Pushy\AMQPPublisher', $publisher);
    }
}
