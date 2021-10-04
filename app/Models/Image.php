<?php

namespace App\Models;

class Image extends BaseModel
{
    protected $fillable = [
        'name',
        'tag',
        'category',
        'image',
        'thumbnail',
    ];
}
