<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CategoryServiceInterface;
use Exception;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Get Categories.
     * @OA\Get(
     *   tags={"Category"},
     *   path="/category",
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully get category",
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
    public function index()
    {
        try {
            $category = $this->categoryService->index();
            return $this->successResponse($category, "category got successfully");
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
}
