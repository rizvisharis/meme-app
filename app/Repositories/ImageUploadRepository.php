<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;

class ImageUploadRepository implements ImageUploadRepositoryInterface
{
    public function get($condition = null)
    {
        return Image::where($condition);
    }

    public function find($id)
    {
        return Image::find($id);
    }

    public function create($requestData)
    {
        return Image::create([
            'name' => $requestData['name'],
            'tag' => $requestData['tag'],
            'category' => $requestData['category'],
            'image' => $requestData['image'],
            'thumbnail' => $requestData['thumbnail'] ?? null,
        ]);
    }

    public function update($requestData, $id)
    {
    }

    public function delete($data)
    {
        return $data->delete();
    }
}
