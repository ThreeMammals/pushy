<?php
declare(strict_types=1);

require __DIR__ . "/../src/FilePublisher.php";

use PHPUnit\Framework\TestCase;

final class SnsPublisherTest extends TestCase
{
    private $publisher; 
    private $client; 

    function setUp()
    {
        $path = 'test_file_publisher';
        $this->publisher = new FilePublisher($path);
    }

    public function testHappyPath(): void
    {      
        $message = [1,2,3,4,5];
        $result = $this->publisher->publish($message);
        $this->assertEquals(
            288,
            $result
        );
    }
}
