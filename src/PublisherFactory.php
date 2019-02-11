<?php
declare(strict_types=1);

namespace Pushy;

use Aws\Sns\SnsClient;
use Aws\Result;
use Ramsey\Uuid\Uuid;

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
				} else {
					throw new Exception('Unrecognised Publisher type');
				}
    }
}