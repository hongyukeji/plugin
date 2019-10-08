<?php

class VoidTest extends PHPUnit_Framework_TestCase
{
    public function testForge()
    {
        $this->assertInstanceOf('Hongyukeji\Plugin\Void', \Hongyukeji\Plugin\Void::forge());
    }
}
