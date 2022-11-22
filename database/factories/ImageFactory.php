<?php

namespace Database\Factories;

use App\Models\Image;
use App\Utils\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
            'tag' => $this->faker->shuffleArray(),
            'category' =>$this->faker->randomElement(Constants::$CATEGORY),
            'image'  => $this->faker->imageUrl,
            'thumbnail' => $this->faker->imageUrl( 640, 480),
        ];
    }
}
