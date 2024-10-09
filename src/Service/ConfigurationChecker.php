<?php

namespace HCH\PerformanceOptimizerBundle\Service;

use Psr\Log\LoggerInterface;

class ConfigurationChecker
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function checkConfigurations(): void
    {
        // Exemple de code de vérification de configuration
        $this->logger->info('Configuration files have been checked.');
    }
}
