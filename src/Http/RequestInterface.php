<?php

namespace D076\PhpFramework\Http;

interface RequestInterface
{
    public static function createFromGlobals(): static;

    public function uri(): string;

    public function previousUri(): string;

    public function method(): string;

    public function input(string $key, $default = null): mixed;

    public function validate(array $rules, array $data): ?array;
}
