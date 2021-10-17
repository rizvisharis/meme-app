<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTraits;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="MEME App Api Documentation",
 *      @OA\Contact(
 *          email="rizvisharis7@gmail.com"
 *      ),
 * )
 * @OA\Tag(
 *     name="MEME App",
 *     description="API Endpoints"
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
class Controller extends BaseController
{
    use ResponseTraits;
//    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
