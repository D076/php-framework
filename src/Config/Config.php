<?php

namespace D076\PhpFramework\Config;

class Config implements ConfigInterface
{
    public static function get(string $key, $default = null): mixed
    {
        [$file, $key] = explode('.', $key);

        $configPath = constant('APP_PATH')."/config/$file.php";

        if (! file_exists($configPath)) {
            return $default;
        }

        $config = require $configPath;

        return $config[$key] ?? $default;
    }
}
