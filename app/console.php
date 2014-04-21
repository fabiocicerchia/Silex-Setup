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

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use App\Utils\DocBlockParser;

// TODO: REVIEW THIS CODE
function registerClass($class, &$console, &$app)
{
    $refClass = new ReflectionClass($class);
    $methods  = $refClass->getMethods(ReflectionMethod::IS_PUBLIC);

    $controller = new $class($app);

    foreach ($methods as $method) {
        $methodName = $method->getName();
        if (preg_match('/command.+$/', $methodName) > 0) {
            registerMethod($methodName, $class, $console, $app, $controller);
        }
    }
}

function registerMethod($methodName, $class, &$console, &$app, &$controller)
{
    $docBlock  = DocBlockParser::parseMethod($class, $methodName);

    $description = $docBlock['title'];
    $command     = $docBlock['command'];
    $help        = $docBlock['description'];

    $console->register($command)
        ->setName($command)
        ->setDescription($description)
        ->setHelp($help)
        ->setCode(
            function (InputInterface $input, OutputInterface $output) use ($app, $controller, $methodName) {
                $controller->$methodName($input, $output);
            }
        );
}

$console = new Application('My Silex Application', '0.1');

registerClass('Controllers\\Console', $console, $app);

$app->boot();

// TODO: FIX THIS
//$console
//    ->addOption('connection', null, InputOption::VALUE_OPTIONAL, 'The connection to use for this command')
//    ->addOption('force', null, InputOption::VALUE_NONE, 'Set this parameter to execute this action')
//    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app, $consoleController) {
//            $consoleController->doctrineDatabaseDropExecute($input, $output);
//    })
//;
//$console
//    ->addOption('connection', null, InputOption::VALUE_OPTIONAL, 'The connection to use for this command')
//    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
//            $consoleController->doctrineDatabaseCreateExecute($input, $output);
//    })
//;

return $console;
