<?php

namespace D076\PhpFramework\Router;

interface RouterInterface
{
    public function dispatch(string $uri, string $method): void;
}
