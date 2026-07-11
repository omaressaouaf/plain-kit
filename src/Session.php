<?php


declare(strict_types=1);

namespace Omaressaouaf\PlainKit;

class Session
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION["_flash"][$key] ?? $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION['_flash'] ?? [])
            || array_key_exists($key, $_SESSION);
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function flash(string $key, mixed $value): void
    {
        $_SESSION["_flash"][$key] = $value;
    }

    public function unflash(): void
    {
        unset($_SESSION["_flash"]);
    }

    public function flush(): void
    {
        session_unset();
    }

    public function destroy(): void
    {
        self::flush();

        session_destroy();

        $cookie_params = session_get_cookie_params();

        setcookie(
            "PHPSESSID",
            "",
            time() - 600,
            $cookie_params["path"],
            $cookie_params["domain"],
            $cookie_params["secure"],
            $cookie_params["httponly"]
        );
    }
}
