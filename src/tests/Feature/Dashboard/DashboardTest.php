<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Purchase;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\ItemCategory;
use App\Models\ItemCondition;

class DashboardTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_dashboard_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_user_can_access_detail_from_item_img()
    {
        // テスト用のデータを作成
        $users = User::factory()->count(10)->create();
        $condition = Condition::factory(4)->create();
        $categories = Category::factory(14)->create();
        $item = Item::factory(5)->create(['user_id' => $users->first()->id]);
        $itemCategories = ItemCategory::factory(9)->create();
        $itemConditions = ItemCondition::factory(5)->create();
        $mylist_items = [];
        $comments = Comment::factory()->count(1)->create(['user_id' => $users->first()->id, 'item_id' => $item->first()->id]);
        $purchasedItemId = Purchase::pluck('item_id')->toArray();

        // ログインユーザーを作成
        $this->actingAs($users->first());

        // コントローラーの関数を実行
        $response = $this->get('/item/' . $item->first()->id);

        // レスポンスの検証
        $response->assertStatus(200);
        $response->assertViewHas('item');
        $response->assertViewHas('categories');
        $response->assertViewHas('mylist_items');
        $response->assertViewHas('comments');
        $response->assertViewHas('purchasedItemId');
    }
}
