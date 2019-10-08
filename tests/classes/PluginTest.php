<?php

use Hongyukeji\Plugin\Plugin;
use Hongyukeji\Plugin\Loader;

class PluginTest extends PHPUnit_Framework_TestCase
{
    public function unlinkConfig()
    {
        if (file_exists(__DIR__.'/../../tests/mock/hongyuvip/fake/composer.php')) {
            unlink(__DIR__.'/../../tests/mock/hongyuvip/fake/composer.php');
        }
    }

    public function testConstruct()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertInstanceOf('Hongyukeji\Plugin\Plugin', $plugin);
    }

    /**
     * @expectedException \DomainException
     */
    public function testConstructThrows()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/blabla');
    }

    public function testGetSetLoader()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $loader = new Loader();
        $plugin->setLoader($loader);
        $this->assertSame($loader, $plugin->getLoader());
    }

    public function testGetDir()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake');
        $this->assertFalse(__DIR__.'/../../tests/mock/hongyuvip/fake' === $plugin->getDir());

        // it always adds a trailing slash
        $this->assertSame(__DIR__.'/../../tests/mock/hongyuvip/fake/', $plugin->getDir());
    }

    public function testGetJsonConfig()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertArrayHasKey('name', $plugin->getJsonConfig());
    }

    public function testGetJsonConfigKey()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertSame('Fake', $plugin->getJsonConfig('extra.name'));
    }

    public function testGetJsonConfigKeyFallback()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertSame('Fake', $plugin->getJsonConfig('extra.doesntexist', 'Fake'));
    }

    /**
     * @expectedException \DomainException
     */
    public function testGetJsonConfigKeyThrows()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertSame('Fake', $plugin->getJsonConfig('extra.doesntexist'));
    }

    /**
     * @expectedException \DomainException
     */
    public function testGetJsonConfigBrokenJsonThrows()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/broken_json/');
        $plugin->getJsonConfig();
    }

    public function testJsonToConfig()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->jsonToConfig();
        $this->assertSame($plugin->getJsonConfig(), $plugin->getConfig());
        $this->unlinkConfig();
    }

    public function testGetConfig()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertArrayHasKey('name', $plugin->getConfig());
        $this->unlinkConfig();
    }

    public function testGetConfigKey()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertSame('Fake', $plugin->getConfig('extra.name'));
        $this->unlinkConfig();
    }

    public function testGetConfigKeyFallback()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $this->assertSame('Fake', $plugin->getConfig('extra.doesntexist', 'Fake'));
        $this->unlinkConfig();
    }

    /**
     * @expectedException \DomainException
     */
    public function testGetConfigKeyFallbackThrows()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->getConfig('extra.doesntexist');
        $this->unlinkConfig();
    }

    public function testRefreshConfig()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->getConfig();

        $plugin->refreshConfig();
        $this->assertFalse(file_exists(__DIR__.'/../../tests/mock/hongyuvip/fake/composer.php'));
        $this->unlinkConfig();
    }

    public function testBootstrap()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->bootstrap();
        // we set a trap in the bootstrap file
        $result = \Hongyukeji\Plugin\Hook::forge('the.bootstrap.was.loaded')->execute()->get('no load');
        $this->assertSame('success', $result);
        $this->unlinkConfig();
    }

    public function testExecute()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->execute();
        $result = \Hongyukeji\Plugin\Hook::forge('hongyuvip\plugin\plugin.execute.hongyuvip/fake')
            ->execute()->get('no load');
        $this->assertSame('success', $result);
        $this->unlinkConfig();
    }

    public function testInstall()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->install();
        $result = \Hongyukeji\Plugin\Hook::forge('hongyuvip\plugin\plugin.install.hongyuvip/fake')
            ->execute()->get('no load');
        $this->assertSame('success', $result);
        $this->unlinkConfig();
    }

    public function testUninstall()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->uninstall();
        $result = \Hongyukeji\Plugin\Hook::forge('hongyuvip\plugin\plugin.uninstall.hongyuvip/fake')
            ->execute()->get('no load');
        $this->assertSame('success', $result);
        $this->unlinkConfig();
    }

    public function testUpgrade()
    {
        $plugin = new Plugin(__DIR__.'/../../tests/mock/hongyuvip/fake/');
        $plugin->upgrade();
        $result = \Hongyukeji\Plugin\Hook::forge('hongyuvip\plugin\plugin.upgrade.hongyuvip/fake')
            ->setObject($this)
            ->setParam('old_revision', $plugin->getConfig('extra.revision', 0))
            ->setParam('new_revision', $plugin->getJsonConfig('extra.revision', 0))
            ->execute();
        $this->assertSame('success', $result->get('no load'));
        $this->assertSame(0, $result->getParam('old_revision'));
        $this->assertSame(0, $result->getParam('new_revision'));
        $this->unlinkConfig();
    }
}
