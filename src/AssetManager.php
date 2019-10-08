<?php

namespace Hongyukeji\Plugin;

class AssetManager extends \Hongyukeji\PluginPackage\AssetManager
{
    /**
     * Returns the Package object that created this instance of AssetManager
     *
     * @return  \Hongyukeji\Theme\Theme|null  The Plugin object that created this instance of AssetManager
     */
    public function getPlugin()
    {
        return parent::getPackage();
    }
}
