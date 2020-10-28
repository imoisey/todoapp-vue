<?php

declare(strict_types=1);

namespace App\Frontend;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UrlGeneratorTwigExtension extends AbstractExtension
{
    private UrlGenerator $urlGenerator;

    public function __construct(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('url', [$this, 'url']),
        ];
    }

    public function url(string $path, array $params = []): string
    {
        return $this->urlGenerator->generate($path, $params);
    }
}
