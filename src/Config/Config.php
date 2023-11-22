<?php

namespace D076\PhpFramework\Config;

class Config implements ConfigInterface
{
    public static function get(string $key, mixed $default = null): mixed
    {
        $exploded = explode('.', $key);
        $file = $exploded[0] ?? null;
        $key = $exploded[1] ?? null;

        if ($file === null || $key === null) {
            return $default;
        }

        $configPath = constant('APP_PATH')."/config/$file.php";

        if (! file_exists($configPath)) {
            return $default;
        }

        $config = require $configPath;

        return $config[$key] ?? $default;
    }
}
