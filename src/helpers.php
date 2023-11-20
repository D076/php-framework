<?php

use D076\PhpFramework\Config\Config;
use D076\PhpFramework\Container\Container;

if (!function_exists('app')) {
    function app(): Container
    {
        return Container::getInstance();
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, array $headers = []): void
    {
        foreach ($headers as $key => $value) {
            header("$key: $value");
        }

        header("Location: $url");
        exit;
    }
}

if (!function_exists('back')) {
    function back(array $headers = []): void
    {
        redirect(app()->request->previousUri(), $headers);
    }
}

if (!function_exists('asset')) {
    function asset(string $url): string
    {
        $baseUrl = rtrim(
            config('app.asset_url') ?? config('app.url', 'localhost:8000'),
            '/'
        );

        return $baseUrl . '/' . ltrim($url, '/');
    }
}

if (!function_exists('blank')) {
    function blank(mixed $value): bool
    {
        if (!isset($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('filled')) {
    function filled(mixed $value): bool
    {
        return !blank($value);
    }
}

if (!function_exists('class_basename')) {
    function class_basename(string|object $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $default;
    }
}

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        return Config::get($key, $default);
    }
}

if (!function_exists('head')) {
    /**
     * Get the first element of an array. Useful for method chaining.
     */
    function head(array|object $array): mixed
    {
        return reset($array);
    }
}

if (!function_exists('last')) {
    /**
     * Get the last element from an array.
     */
    function last(array|object $array): mixed
    {
        return end($array);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     */
    function value(mixed $value, mixed ...$args): mixed
    {
        return $value instanceof Closure ? $value(...$args) : $value;
    }
}
