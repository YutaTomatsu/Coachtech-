<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class DashboardTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_access_detail_from_item_img()
    {
        $items = Item::pluck('id'); // アイテムのIDのリストを取得

        foreach ($items as $id) {
            $response = $this->get('/item/' . $id);

            $response->assertStatus(200)
                ->assertSee('Expected Text'); // 期待するテキストが表示されることを検証する
        }
    }
}
