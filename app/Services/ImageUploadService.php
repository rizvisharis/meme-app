<?php

namespace App\Services;

use App\Http\Resources\ImageResource;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use App\Services\Interfaces\ImageUploadServiceInterface;
use App\Traits\UtilTraits;
use App\Utils\Constants;
use Exception;
use Illuminate\Support\Facades\Storage;

class ImageUploadService implements ImageUploadServiceInterface
{
    use UtilTraits;

    private $imageUploadRepository;

    public function __construct(ImageUploadRepositoryInterface $imageUploadRepository)
    {
        $this->imageUploadRepository = $imageUploadRepository;
    }

    public function store($requestData)
    {
        try {
            $requestData['image'] = $this->saveImage($requestData['image'], $requestData['category']);
            //        $requestData['thumbnail'] = $this->saveThumbnail($requestData['image']); //Todo no neeed this sprint
            $image = $this->imageUploadRepository->create($requestData);
            return new ImageResource($image);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function saveImage($data, $category)
    {
        $pathImage = $data->store('/image/' . $category, 'memes');
        return '/memes/' . $pathImage;
    }

    public function index($requestData)
    {
        try {

            if (isset($requestData['category'])) {
                $condition = [
                    ['category', $requestData['category']]
                ];

                $images = $this->imageUploadRepository->get($condition);

            } else {
                $images = $this->imageUploadRepository->get();
            }

            if (isset($requestData['search'])) {
                $condition = [
                    ['tag', 'like', '%' . $requestData['search'] . '%']
                ];

                $images = $this->imageUploadRepository->get($condition);
            }

            $images->latest();
            $query = $images->paginate(isset($requestData['page-size']) ? (int)$requestData['page-size'] : 10);

            return [
                'images' => ImageResource::collection($query),
                'page_info' => $this->getPaginateInfo($query)
            ];

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function update($requestData, $id)
    {
        try {
            $image = $this->imageUploadRepository->find($id);
            if (!$image)
                throw new Exception(Constants::$ERROR_MESSAGE['id_not_exist'], Constants::$ERROR_CODE['not_found']);

            if (isset($requestData['name'])) $image->name = $requestData['name'];
            if (isset($requestData['tag'])) $image->tag = $requestData['tag'];
            if (isset($requestData['category'])) $image->category = $requestData['category'];
            if (isset($requestData['image'])) $image->image = $this->saveImage($requestData['image'],
                $requestData['category'] ?? $image->category);
            $this->imageUploadRepository->update($image);
            $updatedImage = $this->imageUploadRepository->find($id);
            return new ImageResource($updatedImage);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function delete($id)
    {
        try {
            $image = $this->imageUploadRepository->find($id);
            if (!$image)
                throw new Exception(Constants::$ERROR_MESSAGE['id_not_exist'], Constants::$ERROR_CODE['not_found']);
            $this->imageUploadRepository->delete($image);
            Storage::disk('memes')->delete(substr($image->image,6));
            $condition = [['_id', $id]];
            $deletedImage = $this->imageUploadRepository->get($condition)->onlyTrashed()->first();
            return new ImageResource($deletedImage);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    private function saveThumbnail($data, $category)
    {
        $pathImage = $data->store('/image/' . $category . '/thumbnails', 'memes');
        return '/memes/' . $pathImage;
    }


}
