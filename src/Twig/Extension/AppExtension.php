<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [AppExtensionRuntime::class, 'parseMarkdown'], ['is_safe' => ['html']]),
        ];
    }

}
