# Silex Setup [![Build Status](https://secure.travis-ci.org/fabiocicerchia/Silex-Setup.png)](http://travis-ci.org/fabiocicerchia/Silex-Setup)

## Used Packages
* [Behat](http://behat.org/)
* [Silex](http://silex.sensiolabs.org/)
 * Silex Extensions
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
 * Prevent path traversal attack (generate 406 Not Acceptable)
 * Scan GET and POST data to prevent XSS (generate 406 Not Acceptable)
 * Scan GET and POST data to prevent SQL Injection (very simple filter, generate 406 Not Acceptable)
* Caching
 * Set 1 month of browser-caching to image files
 * Set 2 weeks of browser-caching to CSS and JavaScript
* Mixed
 * Override some PHP ini configuration
 * Auto-correct user-misspelling on URL typed
