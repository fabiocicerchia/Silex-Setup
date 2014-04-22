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

use Silex\Provider\RememberMeServiceProvider;
use SimpleUser\UserServiceProvider;

$app['security.voters'] = function () {};

// Note: As of this writing, RememberMeServiceProvider must be registered *after* SecurityServiceProvider or SecurityServiceProvider
// throws 'InvalidArgumentException' with message 'Identifier "security.remember_me.service.secured_area" is not defined.'
$app->register(new RememberMeServiceProvider());

// Register the SimpleUser service provider.
$app->register($u = new UserServiceProvider());

// Optionally mount the SimpleUser controller provider.
$app->mount('/user', $u);

