<?php
declare(strict_types=1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class PublisherFactoryTests extends TestCase
{
    private $path;
    private $publisherFactory;

    function setUp()
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
        $type = 'SnsPublisher';
        $config = (object) ['type' => $type, 'location' => $this->path];
        $publisher = $this->publisherFactory->get($config);
        $this->assertInstanceOf('\Pushy\SnsPublisher', $publisher);
    }
}
