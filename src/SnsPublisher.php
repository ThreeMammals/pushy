<?php
declare(strict_types=1);

use Aws\Sns\SnsClient;
use Aws\Result;
use Ramsey\Uuid\Uuid;

final class SnsPublisher
{
    protected $client;
    protected $topic_arn;
    protected $uuidProvier;

    public function __construct($topic_arn, UUIDProvider $uuidProvider)
    {
        $this->topic_arn = $topic_arn;
        $this->uuidProvier = $uuidProvider;
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
					'StringValue' => $this->uuidProvier->uuid(),
				],
				'correlationId' => [
					'DataType'    => 'String',
					'StringValue' => $this->uuidProvier->uuid(),
				],
			],
			'Subject'           => 'Pushy',
		];
    }
}