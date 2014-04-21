<?php
/**
 * SilexSetup
 *
 * PHP version 5
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 */

namespace Controllers;

use Silex\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\DBAL\DriverManager;

/**
 * Controllers\Console
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 **/
class Console extends \App\Controllers\Base
{
    /**
     * Dumps all assets to the filesystem
     *
     * @command assetic:dump
     */
    public function commandAsseticDump(InputInterface $input, OutputInterface $output)
    {
        $app = &$this->application;

        if (!$app['assetic.enabled']) {
            return false;
        }

        $dumper = $app['assetic.dumper'];
        if (isset($app['twig'])) {
            $dumper->addTwigAssets();
        }

        $dumper->dumpAssets();
        $output->writeln('<info>Dump finished</info>');
    }

    /**
     * Clears the cache
     *
     * @command cache:clear
     */
    public function commandCacheClear(InputInterface $input, OutputInterface $output)
    {
        $app = &$this->application;

        $cacheDir = $app['cache.path'];
        $finder   = Finder::create()->in($cacheDir)->notName('.gitkeep');

        $filesystem = new Filesystem();
        $filesystem->remove($finder);

        $output->writeln(sprintf("%s <info>success</info>", 'cache:clear'));
    }
}
