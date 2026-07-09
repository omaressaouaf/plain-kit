<?php

namespace Omaressaouaf\PlainKit;

class Response
{
    public function view(string $path, array $context = []): void
    {
        extract($context);

        require app_path("Views/{$path}.view.php");
    }

    public function json(array $data): void
    {
        header("Content-Type: application/json");

        echo json_encode($data);
    }

    public function redirect(string $path): void
    {
        header("location: {$path}");

        exit();
    }

    public function back(): void
    {
        $this->redirect($_SERVER["HTTP_REFERER"]);
    }

    public function abort(int $code = 404): void
    {
        http_response_code($code);

        require base_path("app/Http/Controllers/Failures/{$code}.php");

        die();
    }
}
