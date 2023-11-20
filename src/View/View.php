<?php

namespace D076\PhpFramework\View;

use http\Exception\RuntimeException;

class View implements ViewInterface
{
    private string $title;

    public function __construct()
    {
    }

    public function page(string $name, array $data = [], string $title = ''): void
    {
        $this->title = $title;

        $viewPath = constant('APP_PATH') . "resources/views/$name.php";

        if (!file_exists($viewPath)) {
            throw new RuntimeException("View $name not found");
        }

        extract(array_merge($this->defaultData(), $data));

        include_once $viewPath;
    }

    public function component(string $name, array $data = []): void
    {
        $componentPath = constant('APP_PATH') . "resources/views/components/$name.php";

        if (!file_exists($componentPath)) {
            throw new RuntimeException("Component $name not found");
        }

        extract(array_merge($this->defaultData(), $data));

        include $componentPath;
    }

    private function defaultData(): array
    {
        return [
            'view' => $this
        ];
    }

    public function title(): string
    {
        return $this->title;
    }
}
