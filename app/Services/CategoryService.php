<?php

namespace App\Services;

use App\Services\Interfaces\CategoryServiceInterface;
use App\Utils\Constants;
use Exception;

class CategoryService implements CategoryServiceInterface
{
    public function index()
    {
        try {
            return Constants::$CATEGORY;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
