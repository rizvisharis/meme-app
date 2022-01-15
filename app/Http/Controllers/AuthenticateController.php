<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\AuthenticateServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticateController extends Controller
{
    private $authenticateService;

    public function __construct(AuthenticateServiceInterface $authenticateService)
    {
        $this->authenticateService = $authenticateService;
    }

    /**
     * User login.
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/auth/login",
     *     @OA\Parameter(
     *          name="email",
     *          description="the user email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="email"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="password",
     *          description="The user password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully user login",
     *     @OA\JsonContent()
     *   ),
     *   @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *     ),
     *   @OA\Response(
     *          response=403,
     *          description="access denied",
     *     ),
     *   @OA\Response(
     *          response=404,
     *          description="not found",
     *     ),
     *   @OA\Response(
     *          response=422,
     *          description="unprocessable entity",
     *     ),
     *   @OA\Response(
     *          response=500,
     *          description="internal server error",
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email:rfc,dns|exists:users,email',
                'password' => 'required|min:8',
            ]);

            $request = $request->only([
                'email',
                'password',
            ]);
            $loginData = $this->authenticateService->login($request);
            return $this->successResponse($loginData, 'User login successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
    /**
     * the User forgot password module.
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/auth/forgot-password",
     *     @OA\Parameter(
     *          name="email",
     *          description="the user email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="email"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully reset link sent to email",
     *   ),
     *   @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *     ),
     *   @OA\Response(
     *          response=403,
     *          description="access denied",
     *     ),
     *   @OA\Response(
     *          response=404,
     *          description="not found",
     *     ),
     *   @OA\Response(
     *          response=422,
     *          description="unprocessable entity",
     *     ),
     *   @OA\Response(
     *          response=500,
     *          description="internal server error",
     *     )
     * )
     */
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email:rfc,dns|exists:users,email']);
            $request = $request->only(['email']);

            $loginData = $this->authenticateService->forgotPassword($request);
            return $this->successResponse($loginData, 'Password forgot link sent successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
    /**
     * The password reset module.
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/auth/password-reset",
     *     @OA\Parameter(
     *          name="token",
     *          description="the user token",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          description="the user email password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              format="password"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully reset the password",
     *   ),
     *   @OA\Response(
     *          response=401,
     *          description="unauthorized",
     *     ),
     *   @OA\Response(
     *          response=403,
     *          description="access denied",
     *     ),
     *   @OA\Response(
     *          response=404,
     *          description="not found",
     *     ),
     *   @OA\Response(
     *          response=422,
     *          description="unprocessable entity",
     *     ),
     *   @OA\Response(
     *          response=500,
     *          description="internal server error",
     *     )
     * )
     */
    public function passwordReset(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|exists:forgot_passwords,token',
                'password' => 'required|min:6',
            ]);

            $request = $request->only([
                'token',
                'password',
            ]);

            $loginData = $this->authenticateService->passwordReset($request);
            return $this->successResponse($loginData, 'Password reset successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
}
