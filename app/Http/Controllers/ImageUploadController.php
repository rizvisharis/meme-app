<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ImageUploadServiceInterface;
use App\Utils\Constants;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ImageUploadController extends Controller
{
    private $imageService;

    public function __construct(ImageUploadServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * upload a Image.
     * @OA\Post(
     *   tags={"Image"},
     *   path="/image",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="the meme's image",
     *                     property="image",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *             )
     *         )
     *      ),
     *     @OA\Parameter(
     *          name="name",
     *          description="the meme's name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="tag[]",
     *          description="the meme image tag",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  format="string"
     *              )
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="category",
     *          description="the user's phone number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully upload image",
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
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|min:2|max:255',
                'tag' => 'required|array|min:2|max:255',
                'tag.*' => 'required|distinct|min:2|max:255',
                'category' => 'required|in:' . implode(',', array_keys(Constants::$CATEGORY)),
                'image' => 'required',
            ]);
            $request = $request->only([
                'name',
                'tag',
                'category',
                'image',
            ]);
            $image = $this->imageService->store($request);
            return $this->successResponse($image, 'Image upload successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }

    }

    /**
     * Get Images.
     * @OA\Get(
     *   tags={"Image"},
     *   path="/image",
     *   @OA\Parameter(
     *          name="category",
     *          description="the meme's category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="search",
     *          description="Records per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="page-size",
     *          description="Records per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="Succesfully get all images",
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
     *     ),
     *     security={{ "apiAuth": {} }}
     * )
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'category' => 'sometimes|in:' . implode(',', array_keys(Constants::$CATEGORY)),
                'search' => 'sometimes',
                'page-size' => 'sometimes|integer|gt:0'
            ]);
            $request = $request->only([
                'category',
                'search',
                'page-size',
            ]);
            $images = $this->imageService->index($request);
            return $this->successResponse($images, "images got successfully");
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
