<?php

namespace D076\PhpFramework\Config;

use Dotenv\Dotenv;

class Env implements EnvInterface
{
    private Dotenv $dotenv;

    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(constant('APP_PATH'));
        $this->dotenv->load();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        return blank($value) ? $default : $value;
    }
}
