<?php

namespace App\Services;

use App\Http\Resources\ImageResource;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;
use App\Services\Interfaces\ImageUploadServiceInterface;

class ImageUploadService implements ImageUploadServiceInterface
{
    private $imageUploadRepository;

    public function __construct(ImageUploadRepositoryInterface $imageUploadRepository)
    {
        $this->imageUploadRepository = $imageUploadRepository;
    }

    public function store($requestData)
    {
        $requestData['image'] = $this->saveImage($requestData['image'], $requestData['category']);
//        $requestData['thumbnail'] = $this->saveThumbnail($requestData['image']);
        $image = $this->imageUploadRepository->create($requestData);
        return new ImageResource($image);
    }

    private function saveImage($data, $category)
    {
        $pathImage = $data->store('/image/' . $category, 'memes');
        return '/memes/' . $pathImage;
    }

    public function index($requestData)
    {
        // TODO: Implement index() method.
    }

    public function update($data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    private function saveThumbnail($data, $category)
    {
        $pathImage = $data->store('/image/' . $category . '/thumbnails', 'memes');
        return '/memes/' . $pathImage;
    }



}
