<?php
declare(strict_types=1);


namespace guardiansdk;

class ConfigService
{
    public $file = __DIR__."/config.ini";

    public function getUrl(): string
    {
        $config = parse_ini_file($this->file);
        return $config['url'];
    }
}
