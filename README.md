# Silex Setup
![Project Status](http://stillmaintained.com/fabiocicerchia/Silex-Setup.png)

[![Build Status](https://secure.travis-ci.org/fabiocicerchia/Silex-Setup.png)](http://travis-ci.org/fabiocicerchia/Silex-Setup)

[![Click here to lend your support to: Silex-Setup and make a donation at www.pledgie.com !](http://www.pledgie.com/campaigns/16385.png?skin_name=chrome)](http://www.pledgie.com/campaigns/16385)

## Used Packages
* [Behat](http://behat.org/)
* [Silex](http://silex.sensiolabs.org/)
 * Silex Extensions
* Symfony
 * Config
 * Form
 * Translation
 * Validator
 * Yaml
* [OWASP-CRS](https://www.owasp.org/index.php/Category:OWASP_ModSecurity_Core_Rule_Set_Project)
* XHProf
* [PHPUnit](http://http://www.phpunit.de)
 * DbUnit
 * PHP Code Coverage
 * File_Iterator
 * PHP_Invoker
 * Text_Template
 * PHP_Timer
 * PHP_TokenStream
 * Mock Object
 * Selenium RC
 * Behavior-Driven Development
* Twig Extensions
* [Minify](http://code.google.com/p/minify)
* [Twitter Bootstrap](http://twitter.github.com/bootstrap)
* [jQuery](http://jquery.com)
* [jQuery Mobile](http://jquerymobile.com)
* [jQuery UI](http://jqueryui.com)

## Improvements
* Configuration
 * Local storage of Apache logs (access and error)
 * Local storage of Slow-Pages log (via Apache)
* Bandwidth
 * Save bandwidth by blocking the statics folders if the request isn't legal
* Security
 * Limit the HTTP method to commons (default: GET and POST)
 * Block the POST request if HTTP_REFERER is missing
 * Minify all CSS and JavaScript
* Caching
 * Set 1 month of browser-caching to image files
 * Set 2 weeks of browser-caching to CSS and JavaScript
* Mixed
 * Override some PHP ini configuration
 * Auto-correct user-misspelling on URL typed
