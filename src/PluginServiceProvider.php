<?php

namespace Hongyukeji\Plugin;

use Hongyukeji\Plugin\Loader;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/plugins.php' => config_path('plugins.php'),
        ], 'config');

        if (class_exists('Hongyukeji\Plugin\Loader')){
            $loader = Loader::forge()->addDir(config('plugins.directory', base_path('plugins')));
            foreach ($loader->getAll() as $plugin) {
                if ($plugin->getConfig('extra.status')) {
                    $plugin->execute();
                }
            }
        }
    }

    /*
     * 插件扫描加载机制
     */
    public function plugin()
    {
        $loader = Loader::forge()->addDir(config('plugins.directory', base_path('plugins')));
        $enabled_plugins = config('plugins.enabled_plugins', []);
        foreach ($loader->getAll() as $plugin) {
            if (in_array($plugin->getConfig('name'), $enabled_plugins)) {
                $plugin->execute();
            }
        }
    }
}