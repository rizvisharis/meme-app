<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\AuthenticateServiceInterface;
use App\Utils\Constants;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthenticateService implements AuthenticateServiceInterface
{
    public function login(array $requestData)
    {
        try {
            $user = User::where('email', $requestData['email'])->first();
            if (!$user || !Hash::check($requestData['password'], $user->password))
                throw new Exception(
                    Constants::$ERROR_MESSAGE['no_email_password'], Constants::$ERROR_CODE['not_found']);

            return [
                'token' => $user->createToken($user->first_name)->plainTextToken,
                'user' => $user
            ];
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}
