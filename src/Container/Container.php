<?php

namespace D076\PhpFramework\Container;

use D076\PhpFramework\Http\Request;
use D076\PhpFramework\Http\RequestInterface;
use D076\PhpFramework\Router\Router;
use D076\PhpFramework\Router\RouterInterface;
use D076\PhpFramework\Session\Session;
use D076\PhpFramework\Session\SessionInterface;
use D076\PhpFramework\View\View;
use D076\PhpFramework\View\ViewInterface;

class Container
{
    private static ?Container $instance = null;
    public readonly RequestInterface $request;
    public readonly RouterInterface $router;
    public readonly SessionInterface $session;
    public readonly ViewInterface $view;

    public function __construct()
    {
        $this->registerServices();
    }

    public static function getInstance(): static
    {
        return self::$instance ??= new static();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->session = new Session();
        $this->router = new Router();
        $this->view = new View();
    }
}
