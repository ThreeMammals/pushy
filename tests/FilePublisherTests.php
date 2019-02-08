<?php
declare(strict_types=1);

require __DIR__ . "/../src/FilePublisher.php";
require __DIR__ . "/../src/UUIDProvider.php";

use PHPUnit\Framework\TestCase;

final class SnsPublisherTest extends TestCase
{
    private $publisher; 
    private $client; 
    private $path;

    function setUp()
    {
        $this->path = 'test_file_publisher';
        $this->publisher = new FilePublisher($this->path, new UUIDProvider());
    }

    public function testHappyPath(): void
    {      
        $message = [1,2,3,4,5];
        $result = $this->publisher->publish($message);
        $location = $this->path . '.json';
        $contents = file_get_contents($location);
        $data = json_decode($contents, true);
        $this->assertEquals(
            295,
            $result
        );
        $this->assertEquals(
            $message,
            $data['Message']
        );
    }
}
