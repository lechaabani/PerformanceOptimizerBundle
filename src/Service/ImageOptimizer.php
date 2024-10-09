<?php
namespace HCH\PerformanceOptimizerBundle\Service;

use Psr\Log\LoggerInterface;

class ImageOptimizer
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function optimizeImages(): void
    {
        $imageFiles = glob(__DIR__ . '/../../../public/images/*.{jpg,jpeg,png}', GLOB_BRACE);

        foreach ($imageFiles as $file) {
            $this->compressImage($file);
        }

        $this->logger->info('Images have been optimized.');
    }

    private function compressImage(string $file): void
    {
        $image = imagecreatefromstring(file_get_contents($file));
        if ($image !== false) {
            imagejpeg($image, $file, 75); // Compress to 75% quality
            imagedestroy($image);
        }
    }
}
