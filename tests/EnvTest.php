<?php

namespace D076\PhpFramework\Tests;

use D076\PhpFramework\Config\Env;
use PHPUnit\Framework\TestCase;

class EnvTest extends TestCase
{
    protected Env $env;

    public function setUp(): void
    {
        define('APP_PATH', dirname(__DIR__));

        parent::setUp();
    }

    protected function setEnvFromValues(): void
    {
        $this->env = new Env(env: [
            'foo' => 'bar',
            'null' => null,
            '1int' => 1,
            '1string' => '1',
            'array' => ['foo' => 'bar'],
        ]);
    }

    protected function setEnvFromFile(): void
    {
        $this->env = new Env(envPath: constant('APP_PATH') . '\.env.testing');
    }

    public function testString(): void
    {
        $this->setEnvFromValues();
        $this->assertEquals('bar', $this->env->get('foo'));
        $this->assertTrue('1' === $this->env->get('1string'));
    }

    public function testInt(): void
    {
        $this->setEnvFromValues();
        $this->assertTrue(1 === $this->env->get('1int'));
    }

    public function testNull(): void
    {
        $this->setEnvFromValues();
        $this->assertTrue(is_null($this->env->get('null')));
        $this->assertTrue(is_null($this->env->get('not_exist')));
    }

    public function testArray(): void
    {
        $this->setEnvFromValues();
        $this->assertEquals(['foo' => 'bar'], $this->env->get('array'));
    }

    public function testDefaultValue(): void
    {
        $this->setEnvFromValues();
        $this->assertEquals('default', $this->env->get('DB_PASSWORD', 'default'));
        $this->assertEquals('default', $this->env->get('not_exist', 'default'));
    }

    public function testStringFromFile(): void
    {
        $this->setEnvFromFile();
        $this->assertEquals('test', $this->env->get('DB_DATABASE'));
    }

    public function testIntFromFile(): void
    {
        $this->setEnvFromFile();
        $this->assertTrue(3306 == $this->env->get('DB_PORT'));
    }

    public function testNullFromFile(): void
    {
        $this->setEnvFromFile();
        $this->assertTrue(is_null($this->env->get('DB_PASSWORD')));
        $this->assertTrue(is_null($this->env->get('not_exist')));
    }

    public function testDefaultValueFromFile(): void
    {
        $this->setEnvFromFile();
        $this->assertEquals('default', $this->env->get('DB_PASSWORD', 'default'));
        $this->assertEquals('default', $this->env->get('not_exist', 'default'));
    }
}
