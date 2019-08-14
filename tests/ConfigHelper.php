<?php


class ConfigHelper
{
    public static function getConfig(): array
    {
        try {
            return parse_ini_file(__DIR__."config.ini");
        } catch (Exception $exception) {
            throw new Exception("config file not found :", $exception);
        }
    }
}
