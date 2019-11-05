<?php

namespace Hongyukeji\Plugin;

use Hongyukeji\Plugin\Loader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class PluginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config_path = __DIR__ . '/../config/plugins.php';
        $this->mergeConfigFrom($config_path, 'plugins');
        $this->publishes([
            $config_path => config_path('plugins.php'),
        ], 'config');

        if (class_exists('Hongyukeji\Plugin\Loader')) {
            $loader = Loader::forge()->addDir(config('plugins.directory', base_path('plugins')));
            foreach ($loader->getAll() as $plugin) {
                // 判断插件状态是否启用
                if ($plugin->getConfig('extra.status', false)) {
                    // 加载插件目录src类文件
                    $src_paths = [];
                    $path = str_finish($plugin->getDir(), '/') . "src";
                    $src_paths[$plugin->getConfig('extra.namespace')] = $path;
                    $this->registerClassAutoloader($src_paths);

                    // 插件初始化执行命令
                    $plugin->execute();
                }
            }
        }

    }

    /**
     * Register class autoloader for plugins.
     *
     * @return void
     */
    protected function registerClassAutoloader($paths)
    {
        spl_autoload_register(function ($class) use ($paths) {
            // Traverse in registered plugin paths
            foreach ((array)array_keys($paths) as $namespace) {
                if ($namespace != '' && mb_strpos($class, $namespace) === 0) {
                    // Parse real file path
                    $path = $paths[$namespace] . Str::replaceFirst($namespace, '', $class) . ".php";
                    $path = str_replace('\\', '/', $path);

                    if (file_exists($path)) {
                        // Include class file if it exists
                        include $path;
                    }
                }
            }
        });
    }
}
