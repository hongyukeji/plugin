<?php

class VoidTest extends PHPUnit_Framework_TestCase
{
    public function testForge()
    {
        $this->assertInstanceOf('Hongyukeji\Plugin\Invalid', \Hongyukeji\Plugin\Invalid::forge());
    }
}
