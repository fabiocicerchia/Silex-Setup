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

/**
 * ValidateCodingStandardsTest
 *
 * @category Framework
 * @package  SilexSetup
 * @author   Fabio Cicerchia <info@fabiocicerchia.it>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/fabiocicerchia/Silex-Setup
 **/
class ValidateCodingStandardsTest extends PHPUnit_Framework_TestCase
{
    // {{{ getListOfApplicationFiles
    /**
     * getListOfApplicationFiles
     *
     * @ignore
     * @access public
     * @return array
     */
    public function getListOfApplicationFiles()
    {
        $command  = 'find "' . __DIR__ . '/../../" -name "*.php" -type f';
        $command .= '| egrep -v "' . __DIR__ . '/../../(web|lib|tmp|vendor)/"';
        exec($command, $files);

        $files = array_map('realpath', $files);
        $files = preg_grep('#/(Configs|Tests)/#', $files, PREG_GREP_INVERT);

        $data = array();
        foreach ($files as $file) {
            $data[] = array($file);
        }

        return $data;
    }
    // }}}

    // {{{ testEachClassIsStrictlyValidated
    /**
     * testEachClassIsStrictlyValidated
     *
     * @param string $file The file that will be tested
     *
     * @ignore
     * @access public
     * @return void
     * @dataProvider getListOfApplicationFiles
     */
    public function testEachClassIsStrictlyValidated($file)
    {
        $command  = 'phpcs --report=summary --standard=PSR2 ';
        $command .= '--ignore=Configs/* "' . $file . '"';
        exec($command, $report);

        $this->assertEmpty($report, 'The file doesn\'t respect the PSR2 Coding Standard.');
    }
}
