<?php

namespace Tests\Feature;

use App\Utils\Constants;
use Tests\TestCase;

class MemeUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_upload_image()
    {
        $faker = \Faker\Factory::create();
        dd($faker->image($dir = '/tmp', $width = 640, $height = 480));
        $user = (new \Database\Factories\UserFactory)->create();
        $response = $this->actingAs($user, 'web')->postJson('api/v1/image',[
            'name' => $faker->name(),
            'tag' => [$faker->randomElement(['recent', 'new'])],
            'category' => $faker->randomElement(array_keys(Constants::$CATEGORY)),
            'image'  => $faker->image('public/memes/image', $width = 640, $height = 480),
//            'thumbnail' => $faker->imageUrl( 640, 480),
        ]);

        dd($response);

        $this->assertEquals(1,$this->count($response->json()));
        $response->assertStatus(200);
    }
}
