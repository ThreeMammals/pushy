<?php
declare (strict_types = 1);

namespace Pushy;

final class PublisherFactory
{
    protected $uuidProvider;

    public function __construct(UUIDProvider $uuidProvider)
    {
        $this->uuidProvider = $uuidProvider;
    }

    public function get($config): Publisher
    {
        if ($config->type == 'FilePublisher') {
            return new FilePublisher($config->location, $this->uuidProvider);
        } else if ($config->type == 'SNSPublisher') {
            return new SNSPublisher($config->location, $this->uuidProvider);
        } else if ($config->type == 'AMQPPublisher') {
            return new AMQPPublisher($config->location, $this->uuidProvider);
        } else {
            return new NothingPublisher();
        }
    }
}
