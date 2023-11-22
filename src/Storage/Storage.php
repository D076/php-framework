<?php

namespace D076\PhpFramework\Storage;

class Storage implements StorageInterface
{
    public function url(string $path): string
    {
        $url = config('app.url', 'http://localhost:8000');

        return "$url/storage/$path";
    }

    public function get(string $path): string
    {
        return file_get_contents($this->storagePath($path));
    }

    private function storagePath(string $path): string
    {
        return constant('APP_PATH')."/storage/$path";
    }
}
