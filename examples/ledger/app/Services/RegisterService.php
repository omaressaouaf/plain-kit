<?php


declare(strict_types=1);

namespace Services;

use Omaressaouaf\PlainKit\App;
use Repositories\UserRepository;

class RegisterService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = App::resolve(UserRepository::class);
    }

    public function register(string $name, string $email, string $password): bool
    {
        if ($this->userRepository->existsByEmail($email)) {
            return false;
        }

        $this->userRepository->create($name, $email, $password);

        return true;
    }
}
