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
   
4. Usage Options:


   You can specify options to run specific optimizations:
       ```
       --cache
       ``` : Optimize cache performance.
       ```
       --config
       ``` : Check configuration files.
       ```
       --assets
       ``` : Optimize assets.
       ```
       --images
       ``` : Optimize images.
       ```
       --queries
       ``` : Check for N+1 queries.
       
   Example:
   
       ```
       php bin/console performance:optimize --cache --assets
       ```

5. Contributing:


   Contributions are welcome! If you'd like to contribute to the PerformanceOptimizerBundle, please follow these steps:

    1- Fork the repository.
    
    2- Create a feature branch (git checkout -b feature/YourFeature).
    
    3- Make your changes and commit them (git commit -m 'Add some feature').
    
    4- Push to the branch (git push origin feature/YourFeature).
    
    5- Create a pull request.

## License
This bundle is released under the MIT License.
