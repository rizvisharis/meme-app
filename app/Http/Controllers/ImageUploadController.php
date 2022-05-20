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

    public function create()
    {
        return view('admin.create');
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
     *                  format="string",
     *                  example=""
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
//                'tag' => 'required|array|min:1|max:5',
//                'tag.*' => 'required|distinct|min:2|max:255',
                'category' => 'required|in:' . implode(',', array_keys(Constants::$CATEGORY)),
                'image' => 'required|image',
            ]);
            $request = $request->only([
                'name',
                'tag',
                'category',
                'image',
            ]);
            $this->imageService->store($request);
            return redirect('/')->with('flash_message', 'Image Upload Successfully!');
//            return $this->successResponse($image, 'Image upload successfully');
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
     *     )
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

            if (\Request::is('api/*')) {
                return $this->successResponse($images, "images got successfully");
            }

            return view('admin.index')->with('images', $images['images']);

        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    /**
     * update a Image.
     * @OA\Post (
     *   tags={"Image"},
     *   path="/image/{id}",
     *     @OA\Parameter(
     *          name="id",
     *          description="the image's id ",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\RequestBody(
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
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="tag[]",
     *          description="the meme image tag",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(
     *                  format="string",
     *                  example=""
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
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|min:2|max:255',
                'tag' => 'sometimes|array|max:5',
                'tag.*' => 'distinct|min:2|max:255',
                'category' => 'sometimes|in:' . implode(',', array_keys(Constants::$CATEGORY)),
                'image' => 'sometimes',
            ]);
            $request = $request->only([
                'name',
                'tag',
                'category',
                'image',
            ]);
            $image = $this->imageService->update($request, $id);
            return $this->successResponse($image, 'Image update successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }

    /**
     * delete the image.
     * @OA\Delete(
     *   tags={"Image"},
     *   path="/image/{id}",
     *   @OA\Parameter(
     *          name="id",
     *          description="the image id ",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *   @OA\Response(
     *     response="200",
     *     description="hub delete successfully",
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
    public function delete($id)
    {
        try {
            $image = $this->imageService->delete($id);
            return $this->successResponse($image, 'image delete successfully');
        } catch (ValidationException $validationException) {
            return $this->validationErrorResponse($validationException);
        } catch (Exception $exception) {
            return $this->exceptionErrorResponse($exception);
        }
    }
}
