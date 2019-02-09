<?php
declare(strict_types=1);

namespace Pushy;

use Ramsey\Uuid\Uuid;

final class UUIDProvider
{
    public function uuid(): string {
        $uuid1 = Uuid::uuid1();
        return $uuid1->toString();
	}
}