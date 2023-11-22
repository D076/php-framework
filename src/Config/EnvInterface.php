<?php

namespace D076\PhpFramework\Config;

interface EnvInterface
{
    public function get(string $key, $default = null): mixed;
}
