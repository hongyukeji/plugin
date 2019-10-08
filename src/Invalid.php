<?php

namespace Hongyukeji\Plugin;

/**
 * Class to pass instead of primitive types
 *
 * @author Hongyukeji <support@hongyuvip.com>
 * @package Hongyukeji\Plugin
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License 2.0
 */
class Invalid
{
    /**
     * Use to set default parameters to void
     *
     * @return  \Hongyukeji\Plugin\Invalid
     */
    public static function forge()
    {
        return new static();
    }
}
