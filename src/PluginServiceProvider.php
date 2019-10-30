<?php

namespace Hongyukeji\Plugin;

use Hongyukeji\Plugin\Loader;
use Illuminate\Support\ServiceProvider;

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
                if ($plugin->getConfig('extra.status')) {
                    $path = str_finish($plugin->getDir(), '/') . "src";
                    if (is_dir($path)) {
                        $files = $this->getPathFiles($path);
                        foreach ($files as $file) {
                            $file_path = $path . $file;
                            if (file_exists($file_path) && ends_with($file_path, '.php')) {
                                include_once $file_path;
                            }
                        }
                    }
                    $plugin->execute();
                }
            }
        }
    }

    public function tree(& $array_files, $directory, $dir_name = '')
    {
        $mydir = dir($directory);
        while ($file = $mydir->read()) {
            if ((is_dir("$directory/$file")) AND ($file != ".") AND ($file != "..")) {
                $this->tree($array_files, "$directory/$file", "$dir_name/$file");
            } else if (($file != ".") AND ($file != "..")) {
                $array_files[] = "$dir_name/$file";
            }
        }
        $mydir->close();
    }

    public function getPathFiles($path)
    {
        $array_files = array();
        $this->tree($array_files, $path);
        return $array_files;
    }
}