<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HeaderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_logout()
    {
        $users = User::factory()->count(10)->create();
        $this->actingAs($users->first());

        $response = $this->post('logout');

        $response->assertStatus(302)->assertRedirect('/');
    }

    public function test_user_can_access_mypage_from_mypage_button()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $response = $this->get('/mypage');

        $response->assertStatus(200);
    }

    public function test_user_can_access_sell_from_sell_button()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $response = $this->get('/sell');

        $response->assertStatus(200);
    }

    public function test_user_can_search_from_form()
    {
        $response = $this->get('/search');

        $response->assertStatus(200);
    }

    public function test_header_can_be_changed_by_user_logged_in_or_not()
    {
        $response = $this->get('/sell');
        $response = $this->get('/mypage');
        $response = $this->post('logout');

        $response->assertStatus(302);

    }
}
