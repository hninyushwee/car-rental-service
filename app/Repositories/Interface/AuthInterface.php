<?php

namespace App\Repositories\Interface;

interface AuthInterface
{
    public function register(array $data): array;
    public function login(array $data): ?array;
    public function logout($user): bool;
}