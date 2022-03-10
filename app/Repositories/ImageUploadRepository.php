<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageUploadRepositoryInterface;

class ImageUploadRepository extends BasicRepository implements ImageUploadRepositoryInterface
{
    public function __construct(Image $image)
    {
        $this->model = $image;
    }
}
