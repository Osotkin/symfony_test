<?php

namespace App\Service;

use Demontpx\ParsedownBundle\Parsedown;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownParser
{
    /**
     * @var Parsedown
     */
    private $parsedown;
    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var bool
     */
    private $debug;
    private Security $security;

    public function __construct(
        Parsedown $parsedown,
        AdapterInterface $cache,
        LoggerInterface $markdownLogger,
        bool $debug,
        Security $security
    ) {
        $this->parsedown = $parsedown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
        $this->debug = $debug;
        $this->security = $security;
    }

    public function parse(string $source): string
    {
        if (strpos($source, 'кофе') !== false) {
            $this->logger->info('Статья о кофе', [
                'user' => $this->security->getUser(),
            ]);
        }

        if ($this->debug) {
            return $this->parsedown->text($source);
        }

        return $this->cache->get(
            'markdown_' . md5($source),
            function () use ($source) {
                return $this->parsedown->text($source);
            }
        );
    }
}