<?php

namespace HCH\PerformanceOptimizerBundle\Tests\Command;

use HCH\PerformanceOptimizerBundle\Command\PerformanceOptimizeCommand;
use HCH\PerformanceOptimizerBundle\Service\CacheOptimizer;
use HCH\PerformanceOptimizerBundle\Service\ConfigurationChecker;
use HCH\PerformanceOptimizerBundle\Service\AssetOptimizer;
use HCH\PerformanceOptimizerBundle\Service\ImageOptimizer;
use HCH\PerformanceOptimizerBundle\Service\QueryOptimizationChecker;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class PerformanceOptimizeCommandTest extends TestCase
{
    public function testExecuteWithCacheOption()
    {
        $cacheOptimizerMock = $this->createMock(CacheOptimizer::class);
        $cacheOptimizerMock->expects($this->once())
            ->method('checkCacheConfiguration');

        $command = new PerformanceOptimizeCommand(
            $cacheOptimizerMock,
            $this->createMock(ConfigurationChecker::class),
            $this->createMock(AssetOptimizer::class),
            $this->createMock(ImageOptimizer::class),
            $this->createMock(QueryOptimizationChecker::class)
        );

        $commandTester = new CommandTester($command);
        $commandTester->execute(['--cache' => true]); // Passer l'option cache

        $this->assertStringContainsString('Cache Optimization', $commandTester->getDisplay());
        $this->assertStringContainsString('Cache optimization completed.', $commandTester->getDisplay());
    }

    public function testExecuteWithConfigOption()
    {
        $configurationCheckerMock = $this->createMock(ConfigurationChecker::class);
        $configurationCheckerMock->expects($this->once())
            ->method('checkConfigurations');

        $command = new PerformanceOptimizeCommand(
            $this->createMock(CacheOptimizer::class),
            $configurationCheckerMock,
            $this->createMock(AssetOptimizer::class),
            $this->createMock(ImageOptimizer::class),
            $this->createMock(QueryOptimizationChecker::class)
        );

        $commandTester = new CommandTester($command);
        $commandTester->execute(['--config' => true]); // Passer l'option config

        $this->assertStringContainsString('Configuration Files Check', $commandTester->getDisplay());
        $this->assertStringContainsString('Configuration checks completed.', $commandTester->getDisplay());
    }

    public function testExecuteWithAllOptions()
    {
        $cacheOptimizerMock = $this->createMock(CacheOptimizer::class);
        $cacheOptimizerMock->expects($this->once())
            ->method('checkCacheConfiguration');

        $configurationCheckerMock = $this->createMock(ConfigurationChecker::class);
        $configurationCheckerMock->expects($this->once())
            ->method('checkConfigurations');

        $assetOptimizerMock = $this->createMock(AssetOptimizer::class);
        $assetOptimizerMock->expects($this->once())
            ->method('optimizeAssets');

        $imageOptimizerMock = $this->createMock(ImageOptimizer::class);
        $imageOptimizerMock->expects($this->once())
            ->method('optimizeImages');

        $queryOptimizationCheckerMock = $this->createMock(QueryOptimizationChecker::class);
        $queryOptimizationCheckerMock->expects($this->once())
            ->method('checkForNPlusOneQueries');

        $command = new PerformanceOptimizeCommand(
            $cacheOptimizerMock,
            $configurationCheckerMock,
            $assetOptimizerMock,
            $imageOptimizerMock,
            $queryOptimizationCheckerMock
        );

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            '--cache' => true,
            '--config' => true,
            '--assets' => true,
            '--images' => true,
            '--queries' => true,
        ]);

        $this->assertStringContainsString('Performance Optimizer', $commandTester->getDisplay());
        $this->assertStringContainsString('Cache Optimization', $commandTester->getDisplay());
        $this->assertStringContainsString('Configuration Files Check', $commandTester->getDisplay());
        $this->assertStringContainsString('Assets Optimization', $commandTester->getDisplay());
        $this->assertStringContainsString('Image Compression', $commandTester->getDisplay());
        $this->assertStringContainsString('N+1 Queries Detection', $commandTester->getDisplay());
        $this->assertStringContainsString('All performance optimizations completed.', $commandTester->getDisplay());
    }

    public function testExecuteWithNoOptions()
    {
        $command = new PerformanceOptimizeCommand(
            $this->createMock(CacheOptimizer::class),
            $this->createMock(ConfigurationChecker::class),
            $this->createMock(AssetOptimizer::class),
            $this->createMock(ImageOptimizer::class),
            $this->createMock(QueryOptimizationChecker::class)
        );

        $commandTester = new CommandTester($command);
        $commandTester->execute([]); // Pas d'options

        $this->assertStringContainsString('Performance Optimizer', $commandTester->getDisplay());
        $this->assertStringContainsString('All performance optimizations completed.', $commandTester->getDisplay());
    }
}
