<?php
namespace HCH\PerformanceOptimizerBundle\Service;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class QueryLoggerListener implements SQLLogger
{
    private LoggerInterface $logger;
    private array $queries = [];

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function startQuery($sql, ?array $params = null, ?array $types = null): void
    {
        $this->queries[] = [
            'sql' => $sql,
            'params' => $params,
            'start' => microtime(true),
        ];
    }

    public function stopQuery(): void
    {
        $lastQuery = array_pop($this->queries);
        $lastQuery['duration'] = microtime(true) - $lastQuery['start'];

        if ($lastQuery['duration'] > 0.1) { // Slow query threshold (100ms)
            $this->logger->warning('Slow SQL query detected', [
                'query' => $lastQuery['sql'],
                'params' => $lastQuery['params'],
                'duration' => $lastQuery['duration'],
            ]);
        }
    }
}
