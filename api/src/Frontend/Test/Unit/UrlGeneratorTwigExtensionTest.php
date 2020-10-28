<?php

declare(strict_types=1);

namespace App\Frontend\Test\Unit;

use App\Frontend\UrlGenerator;
use App\Frontend\UrlGeneratorTwigExtension;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

/**
 * @covers \App\Frontend\UrlGeneratorTwigExtension
 */
class UrlGeneratorTwigExtensionTest extends TestCase
{
    public function testSuccess(): void
    {
        $urlGenerator = $this->createMock(UrlGenerator::class);
        $urlGenerator->expects(self::once())->method('generate')->with(
            self::equalTo('path'),
            self::equalTo(['a' => 1, 'b' => 2])
        )->willReturn('http://test/path?a=1&b=2');

        $twig = new Environment(new ArrayLoader([
            'page.html.twig' => '<p>{{ url(\'path\', {\'a\': 1, \'b\': 2}) }}</p>',
        ]));

        $twig->addExtension(new UrlGeneratorTwigExtension($urlGenerator));

        self::assertEquals('<p>http://test/path?a=1&amp;b=2</p>', $twig->render('page.html.twig'));
    }
}
