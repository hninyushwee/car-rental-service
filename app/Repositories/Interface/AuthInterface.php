<?php

namespace App\Repositories\Interface;

interface AuthInterface
{
    public function register(array $data);
    public function login(array $data);
    public function logout($user);
}