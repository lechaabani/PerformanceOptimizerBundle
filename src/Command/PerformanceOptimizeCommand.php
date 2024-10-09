<?php

namespace HCH\PerformanceOptimizerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this
            ->setDescription("Analyze and optimize the application's performance.")
            ->addOption('cache', null, InputOption::VALUE_NONE, 'Optimize cache performance')
            ->addOption('config', null, InputOption::VALUE_NONE, 'Check configuration files')
            ->addOption('assets', null, InputOption::VALUE_NONE, 'Optimize assets')
            ->addOption('images', null, InputOption::VALUE_NONE, 'Optimize images')
            ->addOption('queries', null, InputOption::VALUE_NONE, 'Check for N+1 queries');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Performance Optimizer');

        // Initialiser un tableau pour suivre les sections
        $sectionsCompleted = [];

        // Si aucune option n'est spécifiée, on exécute toutes les optimisations
        if (!$input->getOption('cache') && !$input->getOption('config') && !$input->getOption('assets') && !$input->getOption('images') && !$input->getOption('queries')) {
            // Exécute toutes les optimisations par défaut
            $sectionsCompleted[] = 'Cache Optimization';
            $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
            $this->cacheOptimizer->checkCacheConfiguration();

            $sectionsCompleted[] = 'Configuration Files Check';
            $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
            $this->configurationChecker->checkConfigurations();

            $sectionsCompleted[] = 'Assets Optimization';
            $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
            $this->assetOptimizer->optimizeAssets();

            $sectionsCompleted[] = 'Image Compression';
            $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
            $this->imageOptimizer->optimizeImages();

            $sectionsCompleted[] = 'N+1 Queries Detection';
            $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
            $this->queryOptimizationChecker->checkForNPlusOneQueries();
        } else {
            // Exécutez les optimisations en fonction des options spécifiées
            if ($input->getOption('cache')) {
                $sectionsCompleted[] = 'Cache Optimization';
                $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
                $this->cacheOptimizer->checkCacheConfiguration();
                $io->success('Cache optimization completed.');
            }

            if ($input->getOption('config')) {
                $sectionsCompleted[] = 'Configuration Files Check';
                $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
                $this->configurationChecker->checkConfigurations();
                $io->success('Configuration checks completed.');
            }

            if ($input->getOption('assets')) {
                $sectionsCompleted[] = 'Assets Optimization';
                $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
                $this->assetOptimizer->optimizeAssets();
                $io->success('Assets optimization completed.');
            }

            if ($input->getOption('images')) {
                $sectionsCompleted[] = 'Image Compression';
                $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
                $this->imageOptimizer->optimizeImages();
                $io->success('Image compression completed.');
            }

            if ($input->getOption('queries')) {
                $sectionsCompleted[] = 'N+1 Queries Detection';
                $io->section($sectionsCompleted[count($sectionsCompleted) - 1]);
                $this->queryOptimizationChecker->checkForNPlusOneQueries();
                $io->success('N+1 query detection completed.');
            }
        }

        // Afficher le message de succès à la fin
        $io->success('All performance optimizations completed.');

        return Command::SUCCESS;
    }

}
