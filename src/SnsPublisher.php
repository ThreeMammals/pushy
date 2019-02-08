<?php
declare(strict_types=1);

use Aws\Sns\SnsClient;
use Aws\Result;
use Ramsey\Uuid\Uuid;

final class SnsPublisher
{
    protected $client;
    protected $topic_arn;

    public function __construct($topic_arn)
    {
        $this->topic_arn = $topic_arn;
        $this->client = SnsClient::factory(array(
            'region'  => 'eu-west-1',
            'version' => '2010-03-31'
        ));
    }

    public function publish($data): Result
    {
        $json = json_encode($data);
        $message = $this->prepare($json);
        return $this->client->publish($message);
    }

    private function prepare($message) {
		return [
			'TopicArn'          => $this->topic_arn,
			'Message'           => $message,
			'MessageAttributes' => [
				'causationId'   => [
					'DataType'    => 'String',
					'StringValue' => '0',
				],
				'messageId'     => [
					'DataType'    => 'String',
					'StringValue' => $this->uuid(),
				],
				'correlationId' => [
					'DataType'    => 'String',
					'StringValue' => $this->uuid(),
				],
			],
			'Subject'           => 'Pushy',
		];
    }
    
    private function uuid(): string {
        $uuid1 = Uuid::uuid1();
        return $uuid1->toString();
	}
}