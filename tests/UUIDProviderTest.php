<?php
declare(strict_types=1);

namespace Pushy\Tests;

use PHPUnit\Framework\TestCase;
use Pushy;

final class UUIDProviderTest extends TestCase
{
    public function testHappyPath(): void
    {      
        $uuidProvider = new \Pushy\UUIDProvider();
        
        $this->assertNotNull(
            $uuidProvider->uuid()
        );
    }
}
