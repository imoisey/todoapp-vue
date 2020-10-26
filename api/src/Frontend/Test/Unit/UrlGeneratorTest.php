<?php

declare(strict_types=1);

namespace App\Frontend\Test\Unit;

use App\Frontend\UrlGenerator;
use PHPUnit\Framework\TestCase;

class UrlGeneratorTest extends TestCase
{
    public function testEmpty(): void
    {
        $generator = new UrlGenerator('http://test');

        self::assertEquals('http://test', $generator->generate(''));
    }

    public function testPath(): void
    {
        $generator = new UrlGenerator('http://test');

        self::assertEquals('http://test/path', $generator->generate('path'));
    }

    public function testWithParams(): void
    {
        $generator = new UrlGenerator('http://test');

        self::assertEquals('http://test/path?a=1&b=2', $generator->generate('path', [
            'a' => '1',
            'b' => 2
        ]));
    }
}
