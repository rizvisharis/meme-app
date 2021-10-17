<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Services\Interfaces\AuthenticateServiceInterface;
use App\Utils\Constants;
use Exception;

class AuthenticateService implements AuthenticateServiceInterface
{
    public function login(array $requestData)
    {
        try {
            if (!auth()->attempt($requestData)) throw new Exception(
                Constants::$ERROR_MESSAGE['no_email_password'], Constants::$ERROR_CODE['not_found']);

            return [
                'token' => auth()->user()->createToken(auth()->user()->first_name)->plainTextToken,
                'user' => new UserResource(auth()->user())
            ];
        } catch (Exception $exception) {
            throw $exception;
        }
    }

}
