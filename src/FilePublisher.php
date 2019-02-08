<?php
declare(strict_types=1);

use Aws\Sns\SnsClient;
use Aws\Result;
use Ramsey\Uuid\Uuid;

final class FilePublisher
{
    protected $path;
    protected $type;

    public function __construct($path)
    {
		$this->path = $path;
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
					'StringValue' => $this->uuid(),
				],
				'correlationId' => [
					'DataType'    => 'String',
					'StringValue' => $this->uuid(),
				],
			],
			'Subject'           => 'Pushy',
		]);
    }
    
    private function uuid(): string {
		$uuid1 = Uuid::uuid1();
        return $uuid1->toString();
	}
}