<?php

namespace D076\PhpFramework\Config;

interface ConfigInterface
{
    public static function get(string $key, mixed $default = null): mixed;
}
