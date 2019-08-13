<?php
declare(strict_types=1);

use guardiansdk\ConfigService;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public $config;
    protected function setUp()
    {
        $this->config = new ConfigService();
    }

    public function testParsingConfigFile(): void
    {
        $out = parse_ini_file("src/config.ini");
        $this->assertEquals($out['url'], $this->config->getUrl());
    }
}
