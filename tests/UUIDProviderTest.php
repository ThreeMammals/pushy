<?php
declare(strict_types=1);

require __DIR__ . "/../src/UUIDProvider.php";

use PHPUnit\Framework\TestCase;

final class UUIDProviderTest extends TestCase
{
    public function testHappyPath(): void
    {      
        $uuidProvider = new UUIDProvider();
        
        $this->assertNotNull(
            $uuidProvider->uuid()
        );
    }
}
