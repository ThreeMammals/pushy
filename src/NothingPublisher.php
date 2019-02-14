<?php
declare (strict_types = 1);

namespace Pushy;

use Ramsey\Uuid\Uuid;

final class NothingPublisher implements Publisher
{
    public function __construct()
    {
    }

    public function publish($data, $type)
    {
        return 1;
    }
}
