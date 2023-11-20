<?php

namespace D076\PhpFramework\Config;

interface ConfigInterface
{
    public static function get(string $key, $default = null): mixed;
}
