<?php
declare (strict_types = 1);

namespace Pushy;

use Ramsey\Uuid\Uuid;

final class FilePublisher implements Publisher
{
    protected $path;
    protected $type;
    protected $uuidProvider;

    public function __construct($path, UUIDProvider $uuidProvider)
    {
        $this->path = $path;
        $this->uuidProvider = $uuidProvider;
    }

    public function publish($data, $type)
    {
		$messageId = $this->uuidProvider->uuid();
		$location = $this->path . $type . '-' . $messageId . '.json';
        $message = $this->prepare($data, $messageId);
        return file_put_contents($location, $message);
    }

    private function prepare($message, $messageId)
    {
        return json_encode([
            'Message' => $message,
            'MessageAttributes' => [
                'causationId' => [
                    'DataType' => 'String',
                    'StringValue' => '0',
                ],
                'messageId' => [
                    'DataType' => 'String',
                    'StringValue' => $messageId,
                ],
                'correlationId' => [
                    'DataType' => 'String',
                    'StringValue' => $this->uuidProvider->uuid(),
                ],
            ],
            'Subject' => 'Pushy',
        ]);
    }
}
