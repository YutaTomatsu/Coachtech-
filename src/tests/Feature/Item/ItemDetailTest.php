<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_access_purchage()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/purchage/' . $item->first()->id);

        $response->assertStatus(200);
    }

    public function test_user_can_access_comment()
    {
        $users = User::factory()->create();
        $this->actingAs($users->first());

        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $response = $this->get('/comment/' . $item->first()->id);

        $response->assertStatus(200);
    }

    public function test_user_can_add_or_delete_favorite_item()
    {
        $users = User::factory()->create();
        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);

        $this->actingAs($users->first());

        $response = $this->post('/mylist/toggle', ['item_id' => $item->first()->id]);

        $response->assertStatus(200);
    }


}