<?php

namespace Hongyukeji\Plugin;

/**
 * Collection of utilities used in Hongyukeji\Plugin
 *
 * @author Hongyukeji <support@hongyuvip.com>
 * @package Hongyukeji\Plugin
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License 2.0
 */
class Util
{
    /**
     * Returns the value of a deep associative array by using a dotted notation for the keys
     *
     * @param   array   $config    The config file to fetch the value from
     * @param   string  $section   The dotted keys: akey.anotherkey.key
     * @param   mixed   $fallback  The fallback value
     * @return  mixed
     * @throws  \DomainException  if the fallback is \Hongyukeji\Plugin\Void
     */
    public static function dottedConfig($config, $section, $fallback)
    {
        // get the section with the dot separated string
        $sections = explode('.', $section);
        $current = $config;

        foreach ($sections as $key) {
            if (isset($current[$key])) {
                $current = $current[$key];
            } else {
                if ($fallback instanceof Invalid) {
                    throw new \DomainException;
                }

                return $fallback;
            }
        }

        return $current;
    }

    /**
     * Saves an array to a PHP file with a return statement
     *
     * @param   string  $path   The target path
     * @param   array   $array  The array to save
     */
    public static function saveArrayToFile($path, $array)
    {
        $content = "<?php \n"."return ".var_export($array, true).';';

        file_put_contents($path, $content);
    }
}
