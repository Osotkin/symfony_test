<?php

namespace App\Twig\Runtime;

use App\Service\MarkdownParser;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parseMarkdown($content)
    {
        return $this->markdownParser->parse($content);
    }
}
