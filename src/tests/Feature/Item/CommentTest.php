<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_redirected_to_login()
    {
        $users = User::factory()->create();
        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->post('/comment/' . $item->first()->id);

        $response->assertStatus(302)->assertRedirect('login');
    }

    public function test_user_can_send_a_comment()
    { 
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->post('/comment/' . $item->first()->id);

        $response->assertStatus(302);
    }

    public function test_item_sellar_can_delete_comment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $comments = Comment::factory()->create(['user_id' => $users->first()->id, 'item_id' => $item->first()->id]);

        $response = $this->post('comment//delete/' . $comments->first()->id);

        $response->assertStatus(302);
    }

}