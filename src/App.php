<?php

namespace D076\PhpFramework;

use D076\PhpFramework\Container\Container;

class App
{
    private Container $container;

    public function __construct()
    {
        $this->container = Container::getInstance();
    }

    public function run(): void
    {
        $this->container
            ->router
            ->dispatch(
                $this->container->request->uri(),
                $this->container->request->method()
            );
    }
}