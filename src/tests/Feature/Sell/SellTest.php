<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;

class SellTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_data_can_be_saved()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/sell', [
            'item_name' => '椅子4個セット',
            'price' => 20000,
            'image' => 'chair.jpg',
            'about' => '引っ越しするため出品します！2年ほど使用しており、小さい傷などありますが状態はそこそこ綺麗だと思います！',
            'category' => ['まとめ売り','家具'],
            'condition' => '状態が悪い',
        ]);

        $response->assertStatus(302);
    }

    public function test_validation_is_performed_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/sell', [
            'item_name' => '',
            'price' => 100000000000,
            'image' => '',
            'about' => str_repeat('a', 256),
            'category' => ['まとめ売り', '家具'],
            'condition' => '状態が悪い',
        ]);

        $response->assertStatus(302)->assertSessionHasErrors();
    }
}