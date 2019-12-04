<?php
declare(strict_types=1);


namespace guardiansdk;

class ConfigService
{
    public $file = __DIR__."/config.ini";
    private $config;

    public function __construct()
    {
        $this->config = parse_ini_file($this->file);
    }

    public function getUrl(): string
    {
        return $this->config['url'];
    }
}
