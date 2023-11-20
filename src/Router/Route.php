<?php

namespace D076\PhpFramework\Router;

use Closure;

readonly class Route
{
    public function __construct(
        private string        $uri,
        private string        $method,
        private array|Closure $action,
        private array         $middlewares = []
    )
    {
    }

    public static function get(string $uri, array|Closure $action, array $middlewares = []): static
    {
        return new static($uri, 'GET', $action, $middlewares);
    }

    public static function post(string $uri, array|Closure $action, array $middlewares = []): static
    {
        return new static($uri, 'POST', $action, $middlewares);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction(): array|Closure
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function hasMiddlewares(): bool
    {
        return !empty($this->middlewares);
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
