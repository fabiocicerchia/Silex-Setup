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

use Silex\Provider\DoctrineServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$dbSchemaDirectory = ROOT_PATH . '/app/entities/Models'; // TODO: config.yml

// TODO: http://stackoverflow.com/questions/15909096/silex-and-doctrine-orm
$app['em'] = function ($app) {
	$config = Setup::createAnnotationMetadataConfiguration(array($dbSchemaDirectory), $app['debug']);
    $entityManager = EntityManager::create($app['db']['options'], $config);

    return $entityManager;
};

// DOCTRINE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$app->register(
    new DoctrineServiceProvider(),
    array(
        'db.options'           => $app['db']['options'],
        'db.dbal.class_path'   => ROOT_PATH . '/vendor/doctrine-dbal/lib',
        'db.common.class_path' => ROOT_PATH . '/vendor/doctrine-common/lib',
    )
);

$app->register(
	new DoctrineOrmServiceProvider,
	array(
    	'orm.em.options' => array(
			'mappings' => array(
				array(
					'type' => 'annotation',
					'path' => $dbSchemaDirectory
				)
			)
    	),
	)
);

// $app['em']->persist($customer);
// $app['em']->flush();
