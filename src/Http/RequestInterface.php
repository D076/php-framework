<?php

namespace D076\PhpFramework\Http;

use D076\PhpFramework\Http\Upload\UploadedFileInterface;

interface RequestInterface
{
    public static function createFromGlobals(): static;

    public function uri(): string;

    public function previousUri(): string;

    public function method(): string;

    public function input(string $key, $default = null): mixed;

    public function validate(array $rules, array $data): ?array;

    public function file(string $key): ?UploadedFileInterface;
}
