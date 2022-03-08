<?php

namespace Tests\Feature;

use Tests\TestCase;

class MemeUploadTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->getJson('api/v1/image');
//        dd($response);
        $this->assertEquals(1,$this->count($response->json()));
    }
}
