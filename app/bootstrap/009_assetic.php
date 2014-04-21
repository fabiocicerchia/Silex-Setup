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

use SilexAssetic\AsseticServiceProvider;
use Assetic\Filter\CssMinFilter;
use Assetic\Filter\Yui\CssCompressorFilter;
use Assetic\Filter\Yui\JsCompressorFilter;

// ASSETIC ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$app['assetic.enabled'] = true;

$app->register(new AsseticServiceProvider(), array(
    'assetic.path_to_web' => ROOT_PATH,
    'assetic.options' => array(
        'auto_dump_assets' => true,
        'debug'            => $app['debug']
    ),
    'assetic.filters' => $app->protect(
		function($fm) {
        	$fm->set('cssmin', new CssMinFilter());

			$fm->set(
				'yui_css',
				new CssCompressorFilter(
	            	ROOT_PATH . '/vendor/nervo/yuicompressor/yuicompressor.jar'
	        	)
			);

			$fm->set(
				'yui_js',
				new JsCompressorFilter(
	            	ROOT_PATH . '/vendor/nervo/yuicompressor/yuicompressor.jar'
	        	)
			);
    	}
	)
));

//$app['assetic.asset_manager'] = $app->share(
//    $app->extend('assetic.asset_manager', function($am, $app) {
//        $am->set('styles', new Assetic\Asset\AssetCache(
//            new Assetic\Asset\GlobAsset(
//                ROOT_PATH . '/web/*.css',
//                array($app['assetic.filter_manager']->get('yui_css'))
//            ),
//            new Assetic\Cache\FilesystemCache(ROOT_PATH . '/var/cache/assetic')
//        ));
//        $am->get('styles')->setTargetPath('css/styles.css');
//
//        return $am;
//    })
//);
