<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class MypageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_access_profile_from_profile_button()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);
    }
}
