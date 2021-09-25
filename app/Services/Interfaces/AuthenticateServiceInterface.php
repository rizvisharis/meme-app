<?php

namespace App\Services\Interfaces;

interface AuthenticateServiceInterface
{
    public function login(array $request);
}
