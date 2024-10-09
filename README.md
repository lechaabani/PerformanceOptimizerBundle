# PerformanceOptimizerBundle

A Symfony bundle for automatic performance optimization.

## Features
- Analyze database queries.
- Check cache configuration.
- Display performance metrics in the profiler.

## Installation

1. Add the bundle to your project:
   ```bash
   composer require hch/performance-optimizer-bundle
   ```

2. Enable the bundle in your `config/bundles.php` file:
   ```php
   return [
       // ...
       HCH\PerformanceOptimizerBundle\PerformanceOptimizerBundle::class => ['all' => true],
   ];
   ```

3. Run the optimization command:
   ```bash
   php bin/console performance:optimize
   ```

## License
This bundle is released under the MIT License.
