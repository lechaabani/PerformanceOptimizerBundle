<?php
namespace HCH\PerformanceOptimizerBundle\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Psr\Log\LoggerInterface;

class CacheOptimizer
{
    private CacheInterface $cache;
    private LoggerInterface $logger;

    public function __construct(CacheInterface $cache, LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function checkCacheConfiguration(): void
    {
        if (!$this->cache->hasItem('cache_test')) {
            $this->logger->warning('Le cache n\'est pas configuré correctement.');
        } else {
            $this->logger->info('La configuration du cache est correcte.');
        }
    }
}
