<?php

namespace D076\PhpFramework\Http\Middleware;

abstract class AbstractMiddleware
{
    abstract public function handle(): void;
}
