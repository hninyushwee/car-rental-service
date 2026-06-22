<?php

namespace App\Repositories\Interface;

interface UserInterface
{
    public function register(array $data);
    public function login(array $data);
    public function logout($user);
}