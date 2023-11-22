<?php

namespace D076\PhpFramework\Container;

use D076\PhpFramework\Auth\Auth;
use D076\PhpFramework\Auth\AuthInterface;
use D076\PhpFramework\Config\Env;
use D076\PhpFramework\Database\Database;
use D076\PhpFramework\Database\DatabaseInterface;
use D076\PhpFramework\Http\Request;
use D076\PhpFramework\Http\RequestInterface;
use D076\PhpFramework\Router\Router;
use D076\PhpFramework\Router\RouterInterface;
use D076\PhpFramework\Session\Session;
use D076\PhpFramework\Session\SessionInterface;
use D076\PhpFramework\Storage\Storage;
use D076\PhpFramework\Storage\StorageInterface;
use D076\PhpFramework\View\View;
use D076\PhpFramework\View\ViewInterface;

class Container
{
    public readonly RequestInterface $request;
    public readonly RouterInterface $router;
    public readonly SessionInterface $session;
    public readonly ViewInterface $view;
    public readonly DatabaseInterface|null $db;
    public readonly AuthInterface $auth;
    public readonly StorageInterface $storage;
    public readonly Env $env;

    private static ?Container $instance = null;

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
        $this->auth = new Auth();
        $this->storage = new Storage();
        $this->env = new Env();

        if (config('database.enabled', true)) {
            $this->db = new Database([
                'driver' => config('database.driver', 'mysql'),
                'host' => config('database.host', 'localhost'),
                'port' => config('database.port', 3306),
                'database' => config('database.database'),
                'username' => config('database.username'),
                'password' => config('database.password', ''),
                'charset' => config('database.charset', 'utf8'),
            ]);
        } else {
            $this->db = null;
        }
    }
}
