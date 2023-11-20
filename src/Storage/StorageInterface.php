<?php

namespace D076\PhpFramework\Storage;

interface StorageInterface
{
    public function url(string $path): string;

    public function get(string $path): string;
}
