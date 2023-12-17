<?php

namespace D076\PhpFramework\Config;

class Env implements EnvInterface
{
    private array $env = [];
    private string $envPath;

    public function __construct(?string $envPath = null, array $env = [])
    {
        $this->envPath = $envPath ?? constant('APP_PATH').'/.env';

        if (empty($env)) {
            $this->loadEnv();
        } else {
            $this->env = $env;
        }
    }

    private function loadEnv(): void
    {
        try {
            if (! is_readable($this->envPath)) {
                throw new \RuntimeException(sprintf('%s file is not readable', $this->envPath));
            }

            $lines = file($this->envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                [$name, $value] = explode('=', $line, 2);

                $this->env[$this->getClearValue($name)] = $this->getClearValue($value);
            }
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Error loading .env file: '.$exception->getMessage());
        }
    }

    private function getClearValue(string $value): ?string
    {
        $value = trim($value);

        if ($value === 'true') {
            return true;
        } elseif ($value === 'false') {
            return false;
        } elseif ($value === 'null') {
            return null;
        }

        $value = trim(str_replace(["\r", "\n"], '', $value), " \t\n\r\0\x0B'\"");

        return blank($value) ? null : $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->env[$key] ?? $default;
    }
}
