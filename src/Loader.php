<?php

namespace Hongyukeji\Plugin;

/**
 * Automates loading of plugins
 *
 * @author   Hongyukeji <support@hongyuvip.com>
 * @package  Hongyukeji\Plugin
 * @license  http://www.apache.org/licenses/LICENSE-2.0.html Apache License 2.0
 */
class Loader extends \Hongyukeji\PluginPackage\Loader
{
    /**
     * The type of package in use. Can be in example 'theme' or 'plugin'
     * Override this to change type of package
     *
     * @var  string
     */
    protected $type_name = 'plugin';

    /**
     * The class into which the resulting objects are created.
     * Override this, in example Hongyukeji\Plugin\Plugin or Hongyukeji\Theme\Theme
     *
     * @var  string
     */
    protected $type_class = 'Hongyukeji\Plugin\Plugin';

    /**
     * Gets all the plugins or the plugins from the directory
     *
     * @return  \Hongyukeji\Plugin\Plugin[]  All the plugins or the plugins in the directory
     * @throws  \OutOfBoundsException   If there isn't such a $dir_name set
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * Gets a single plugin object
     *
     * @param   string  $slug               The slug of the plugin
     *
     * @return  \Hongyukeji\Plugin\Plugin
     * @throws  \OutOfBoundsException  if the plugin doesn't exist
     */
    public function get($slug)
    {
        return parent::get($slug);
    }
}
