<?php

namespace Hongyukeji\Plugin;

/**
 * Holds data on a plugin package
 *
 * @author Hongyukeji <support@hongyuvip.com>
 * @package Hongyukeji\Plugin
 * @license http://www.apache.org/licenses/LICENSE-2.0.html Apache License 2.0
 */
class Plugin extends \Hongyukeji\PluginPackage\Package
{
    /**
     * Returns an AssetManager object to deal with the assets
     *
     * @return  \Hongyukeji\Plugin\AssetManager  A new instance of the AssetManager
     */
    public function getAssetManager()
    {
        if ($this->asset_manager !== null) {
            return $this->asset_manager;
        }

        return $this->asset_manager = new AssetManager($this);
    }

    /**
     * Runs the execution block
     *
     * @return  \Hongyukeji\Plugin\Plugin
     */
    public function execute()
    {
        // clear the hook since we might have an old one
        \Hongyukeji\Plugin\Event::clear(get_class().'::execute.'.$this->getConfig('name'));

        $this->bootstrap();

        \Hongyukeji\Plugin\Hook::forge(get_class().'::execute.'.$this->getConfig('name'))
            ->setObject($this)
            ->execute();

        return $this;
    }

    /**
     * Triggers the install methods for the plugin
     *
     * @return  \Hongyukeji\Plugin\Plugin
     */
    public function install()
    {
        // clear the hook since we might have an old one
        \Hongyukeji\Plugin\Event::clear(get_class().'::install.'.$this->getJsonConfig('name'));

        // execute the bootstrap to get the events instantiated
        $this->bootstrap();

        \Hongyukeji\Plugin\Hook::forge(get_class().'::install.'.$this->getJsonConfig('name'))
            ->setObject($this)
            ->execute();

        return $this;
    }

    /**
     * Triggers the remove methods for the plugin. Doesn't remove the files.
     *
     * @return  \Hongyukeji\Plugin\Plugin
     */
    public function uninstall()
    {
        // clear the hook since we might have an old one
        \Hongyukeji\Plugin\Event::clear(get_class().'::uninstall.'.$this->getJsonConfig('name'));

        // execute the bootstrap to get the events instantiated
        $this->bootstrap();

        \Hongyukeji\Plugin\Hook::forge(get_class().'::uninstall.'.$this->getJsonConfig('name'))
            ->setObject($this)
            ->execute();

        return $this;
    }

    /**
     * Triggers the upgrade methods for the plugin. At this point the files MUST have changed.
     * It will give two parameters to the Event: old_revision and new_revision, which are previous and new value
     * for extra.revision in the composer.json. These can be used to determine which actions to undertake.
     *
     * @return  \Hongyukeji\Plugin\Plugin
     */
    public function upgrade()
    {
        // clear the json data so we use the latest
        $this->clearJsonConfig();

        // clear the hook since we for sure have an old one
        \Hongyukeji\Plugin\Event::clear(get_class().'::upgrade.'.$this->getJsonConfig('name'));

        // execute the bootstrap to get the events re-instantiated
        $this->bootstrap();

        // run the event
        \Hongyukeji\Plugin\Hook::forge(get_class().'::upgrade.'.$this->getJsonConfig('name'))
            ->setObject($this)
            // the PHP config holds the old revision
            ->setParam('old_revision', $this->getConfig('extra.revision', 0))
            // the JSON config holds the new revision
            ->setParam('new_revision', $this->getJsonConfig('extra.revision', 0))
            ->execute();

        // update the PHP config file so it has the new revision
        $this->refreshConfig();

        return $this;
    }
}
