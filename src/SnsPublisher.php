<?php
declare (strict_types = 1);

namespace Pushy;

use Aws\Sns\SnsClient;
use Ramsey\Uuid\Uuid;

final class SNSPublisher implements Publisher
{
    protected $client;
    protected $topic_arn;
    protected $uuidProvider;

    public function __construct($topic_arn, UUIDProvider $uuidProvider)
    {
        $this->topic_arn = $topic_arn;
        $this->uuidProvider = $uuidProvider;
        $this->client = SnsClient::factory(array(
            'region' => 'eu-west-1',
            'version' => '2010-03-31',
        ));
    }

    public function publish($data, $type)
    {
        $json = json_encode($data);
        $message = $this->prepare($json, $type);
        return $this->client->publish($message);
    }

    private function prepare($message, $type)
    {
        return [
            'TopicArn' => $this->topic_arn . $type,
            'Message' => $message,
            'MessageAttributes' => [
                'causationId' => [
                    'DataType' => 'String',
                    'StringValue' => '0',
                ],
                'messageId' => [
                    'DataType' => 'String',
                    'StringValue' => $this->uuidProvider->uuid(),
                ],
                'correlationId' => [
                    'DataType' => 'String',
                    'StringValue' => $this->uuidProvider->uuid(),
                ],
            ],
            'Subject' => 'Pushy',
        ];
    }
}
