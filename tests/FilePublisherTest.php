<?php
declare (strict_types = 1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class FilePublisherTest extends TestCase
{
    private $publisher;
    private $client;
    private $path;

    public function setUp()
    {
        $this->path = 'test_file_publisher';
        $this->publisher = new \Pushy\FilePublisher($this->path, new \Pushy\UUIDProvider());
    }

    public function testHappyPath(): void
    {
        $message = [1, 2, 3, 4, 5];
        $result = $this->publisher->publish($message, "InputEvent");
        $this->assertEquals(
            295,
            $result
        );
    }
}
