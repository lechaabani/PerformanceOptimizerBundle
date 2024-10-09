<?php
namespace HCH\PerformanceOptimizerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use HCH\PerformanceOptimizerBundle\Service\CacheOptimizer;
use HCH\PerformanceOptimizerBundle\Service\ConfigurationChecker;
use HCH\PerformanceOptimizerBundle\Service\AssetOptimizer;
use HCH\PerformanceOptimizerBundle\Service\ImageOptimizer;
use HCH\PerformanceOptimizerBundle\Service\QueryOptimizationChecker;

class PerformanceOptimizeCommand extends Command
{
    protected static $defaultName = 'performance:optimize';

    private CacheOptimizer $cacheOptimizer;
    private ConfigurationChecker $configurationChecker;
    private AssetOptimizer $assetOptimizer;
    private ImageOptimizer $imageOptimizer;
    private QueryOptimizationChecker $queryOptimizationChecker;

    public function __construct(
        CacheOptimizer $cacheOptimizer,
        ConfigurationChecker $configurationChecker,
        AssetOptimizer $assetOptimizer,
        ImageOptimizer $imageOptimizer,
        QueryOptimizationChecker $queryOptimizationChecker
    ) {
        parent::__construct();
        $this->cacheOptimizer = $cacheOptimizer;
        $this->configurationChecker = $configurationChecker;
        $this->assetOptimizer = $assetOptimizer;
        $this->imageOptimizer = $imageOptimizer;
        $this->queryOptimizationChecker = $queryOptimizationChecker;
    }

    protected function configure()
    {
        $this->setDescription("Analyze and optimize the application's performance.");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Performance Optimizer');

        $io->section('Cache Optimization');
        $this->cacheOptimizer->checkCacheConfiguration();

        $io->section('Configuration Files Check');
        $this->configurationChecker->checkConfigurations();

        $io->section('Assets Optimization');
        $this->assetOptimizer->optimizeAssets();

        $io->section('Image Compression');
        $this->imageOptimizer->optimizeImages();

        $io->section('N+1 Queries Detection');
        $this->queryOptimizationChecker->checkForNPlusOneQueries();

        $io->success('Performance optimization completed.');
        return Command::SUCCESS;
    }
}
