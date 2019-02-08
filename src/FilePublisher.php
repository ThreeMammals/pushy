<?php
declare(strict_types=1);

use Aws\Sns\SnsClient;
use Aws\Result;
use Ramsey\Uuid\Uuid;

final class FilePublisher
{
    protected $path;
		protected $type;
		protected $uuidProvier;

    public function __construct($path, UUIDProvider $uuidProvider)
    {
				$this->path = $path;
				$this->uuidProvier = $uuidProvider;
    }

    public function publish($data): int
    {
				$location = $this->path . '.json';
        $message = $this->prepare($data);
        return file_put_contents($location, $message);
    }

    private function prepare($message) {
		return json_encode([
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
		]);
    }
}