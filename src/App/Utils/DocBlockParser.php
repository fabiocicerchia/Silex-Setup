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

namespace App\Utils;

class DocBlockParser
{
    public static function extractInfo($docBlock)
    {
        $info = array();
        if (preg_match_all('/@(\w+)\s+(.*)\r?\n/m', $docBlock, $matches)) {
            foreach ($matches[1] as $idx => $key) {
                if (!empty($info[$key])) {
                    if (!is_array($info[$key])) {
                        $info[$key] = (array) $info[$key];
                    }
                    $info[$key][] = $matches[2][$idx];
                } else {
                    $info[$key] = $matches[2][$idx];
                }
            }
        }

        if (preg_match_all('/\*[ \t]+(.+)\r?\n/', $docBlock, $matches)) {
            $description         = preg_grep('/^@/', $matches[1], PREG_GREP_INVERT);
            $info['title']       = array_pop($description);
            $info['description'] = implode(PHP_EOL, $description);
        }

        return $info;
    }

    public static function parseClass($className)
    {
        $reflector      = new \ReflectionClass($className);
        $classDocBlock  = $reflector->getDocComment();

        return self::extractInfo($classDocBlock);
    }

    public static function parseMethod($className, $methodName)
    {
        $reflector      = new \ReflectionClass($className);
        $methodDocBlock = $reflector->getMethod($methodName)->getDocComment();

        return self::extractInfo($methodDocBlock);
    }
}
