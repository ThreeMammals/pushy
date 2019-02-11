<?php
declare(strict_types=1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Aws\Sns\SnsClient;
use Aws\Result;
use Pushy;

final class SnsPublisherTest extends TestCase
{
    private $publisher; 
    private $client; 

    function setUp()
    {
        $topic_arn = 'arn:aws:sns:eu-west-1:940731442544:dev-InputEvent';
        $this->publisher = new \Pushy\SNSPublisher($topic_arn, new \Pushy\UUIDProvider());
    }

    public function testHappyPath(): void
    {      
        $message = [1,2,3,4,5];
        $result = $this->publisher->publish($message);
        $this->assertEquals(
            200,
            $result['@metadata']['statusCode']
        );
    }
}
