<?php

namespace HCH\PerformanceOptimizerBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class QueryOptimizationChecker
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function checkForNPlusOneQueries(): void
    {
        $configuration = $this->entityManager->getConnection()->getConfiguration();
        $sqlLogger = $configuration->getSQLLogger();

        if ($sqlLogger === null) {
            $this->logger->warning('SQL Logger is not configured.');
            return;
        }

        $queryLog = $sqlLogger->queries ?? [];
        $repeatedQueries = array_count_values(array_column($queryLog, 'sql'));

        foreach ($repeatedQueries as $query => $count) {
            if ($count > 10) { // Ex: un seuil pour détecter les problèmes N+1
                $this->logger->warning('N+1 problem detected', [
                    'query' => $query,
                    'count' => $count,
                ]);
            }
        }
    }
}
