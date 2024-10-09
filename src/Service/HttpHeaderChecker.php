<?php
namespace HCH\PerformanceOptimizerBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;

class HttpHeaderChecker
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function checkHttpHeaders(): void
    {
        // Simulate a response for the demonstration
        $response = new Response();
        $response->headers->set('Cache-Control', 'no-cache');

        $cacheControl = $response->headers->get('Cache-Control');
        if (!$cacheControl || strpos($cacheControl, 'max-age=') === false) {
            $this->logger->warning('HTTP headers are not optimized for caching.', [
                'header' => $cacheControl,
            ]);
        }
    }
}
