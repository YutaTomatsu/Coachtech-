<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Models\User;

class ProfileTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_redirected_to_login()
    {
        $response = $this->get('/mypage/profile');

        $response->assertStatus(302)->assertRedirect('login');
    }

    public function test_user_can_register_profile()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $request = new Request([
            'name' => 'John Doe',
            'postcode' => '123-4567',
            'address' => '住所',
            'build' => '建物名',
        ]);

        $response = $this->post('/mypage/profile', $request->toArray());

        $response->assertStatus(302)->assertRedirect('/')->assertSessionHas('status');
    }

    public function test_update_profile_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'name' => '',
            'postcode' => '1234567',
            'address' => '',
            'build' => str_repeat('a', 256),
        ];

        $response = $this->post('/mypage/profile', $invalidData);

        $response->assertStatus(302)->assertSessionHasErrors();
    }
}
