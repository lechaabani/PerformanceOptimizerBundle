<?php

namespace HCH\PerformanceOptimizerBundle\Service;

use Psr\Log\LoggerInterface;

class AssetOptimizer
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function optimizeAssets(): void
    {
        // Logique d'optimisation des fichiers CSS/JS
        $this->logger->info('Assets have been optimized.');
    }
}
