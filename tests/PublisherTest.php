<?php
declare(strict_types=1);

require __DIR__ . "/../src/Publisher.php";

use PHPUnit\Framework\TestCase;

final class PublisherTest extends TestCase
{
    public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Publisher::class,
            Publisher::fromString('user@example.com')
        );
    }

    public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Publisher::fromString('invalid');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals(
            'user@example.com',
            Publisher::fromString('user@example.com')
        );
    }
}
