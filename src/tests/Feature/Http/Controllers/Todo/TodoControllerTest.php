<?php

namespace Tests\Feature\Http\Controllers\Todo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoControllerTest extends TestCase
{
    /** @test */
    public function get正常系()
    {
        $response = $this->getJson(
            route(
                'getTodo',
                [
                    'id' => 1,
                ]
            )
        );

        $response->assertStatus(200);
    }
}
