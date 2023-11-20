<?php

namespace D076\PhpFramework\Http;

use D076\PhpFramework\Validator\Validator;
use D076\PhpFramework\Validator\ValidatorInterface;

readonly class Request implements RequestInterface
{
    private ValidatorInterface $validator;

    public function __construct(
        public array $get,
        public array $post,
        public array $server,
        public array $files,
        public array $cookies,
    )
    {
        $this->validator = new Validator();
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

    public function uri(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function previousUri(): string
    {
        return $this->server['HTTP_REFERER'] ?? config('app.url', 'localhost:8000');
    }

    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function input(string $key, $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function validate(array $rules, array $data, $withRedirectBack = true): ?array
    {
        $isPassed = $this->validator->validate($data, $rules);

        if (!$isPassed && $withRedirectBack) {
            foreach ($this->validator->errors() as $field => $errors) {
                app()->session->set($field, $errors);
            }

            back();
        }

        return empty($this->validator->errors())
            ? null
            : $this->validator->errors();
    }
}
