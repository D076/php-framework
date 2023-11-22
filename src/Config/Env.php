<?php

namespace D076\PhpFramework\Config;

class Env implements EnvInterface
{
    private array $env = [];

    public function __construct()
    {
        $this->loadEnv();
    }

    private function loadEnv(): void
    {
        try {
            $path = constant('APP_PATH') . '/.env';

            if (!is_readable($path)) {
                throw new \RuntimeException(sprintf('%s file is not readable', $path));
            }

            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);

                $this->env[$this->getClearValue($name)] = $this->getClearValue($value);
            }
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Error loading .env file: ' . $exception->getMessage());
        }
    }

    private function getClearValue(string $str): ?string
    {
        $str = trim($str);

        if ($str === 'true') {
            return true;
        } elseif ($str === 'false') {
            return false;
        } elseif ($str === 'null') {
            return null;
        }

        $str = trim(str_replace(["\r", "\n"], '', $str), " \t\n\r\0\x0B'\"");

        return blank($str) ? null : $str;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->env[$key] ?? $default;
    }
}
