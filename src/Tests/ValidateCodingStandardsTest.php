<?php
class ValidateCodingStandardsTest extends PHPUnit_Framework_TestCase
{
    public function getListOfApplicationFiles()
    {
        $command = 'find "' . __DIR__ . '/../../" -name "*.php" -type f | egrep -v "' . __DIR__ . '/../../(web|lib)/"';
        exec($command, $files);
        $files = array_map('realpath', $files);
        $files = preg_grep('#/(Configs|Tests)/#', $files, PREG_GREP_INVERT);

        $data = array();
        foreach($files as $file) {
            $data[] = array($file);
        }

        return $data;
    }

    /**
     * @dataProvider getListOfApplicationFiles
     */
    public function testEachClassIsStrictlyValidated($file)
    {
        $command = 'phpcs --report=summary --standard=PEAR --extensions=php --ignore=Configs/* "' . $file . '"';
        exec($command, $report);

        if (!empty($report)) {
            $this->fail("The file doesn't respect the PEAR Coding Standard.");
        }
    }
}
