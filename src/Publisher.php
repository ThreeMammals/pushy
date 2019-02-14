<?php
declare (strict_types = 1);

namespace Pushy;

interface Publisher
{
    public function publish($data, $type);
}
