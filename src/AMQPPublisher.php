<?php
declare (strict_types = 1);

namespace Pushy;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

final class AMQPPublisher implements Publisher
{
    protected $client;
    protected $topic_arn;
    protected $uuidProvider;
    protected $exchange;
    protected $queue;

    public function __construct($topic_arn, UUIDProvider $uuidProvider)
    {
        $this->exchange = 'router';
        $this->queue = 'msgs';
        $this->topic_arn = $topic_arn;
        $this->uuidProvider = $uuidProvider;
        $this->connection = new AMQPStreamConnection('rabbit', 5672, 'guest', 'guest', '/');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind($this->queue, $this->exchange);
    }

    public function publish($data, $type)
    {
        $json = json_encode($data);
        $body = json_encode($this->prepare($json, $type));
        $message = new AMQPMessage($body, array('content_type' => 'application/json', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        return $this->channel->basic_publish($message, $this->exchange);
    }

    private function prepare($message, $type)
    {
        return [
            'Type' => $type,
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
