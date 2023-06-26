<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\User;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    private $items = [
        [
            'id' => 1,
            'user_id' => 1,
            'item_name' => 'テディベア',
            'price' => 500,
            'image' => '/storage/items/bear.jpg',
            'about' => '娘が昔所有していたものですが、娘が成長し、不要になったため売りに出します。',
        ],
        [
            'id' => 2,
            'user_id' => 2,
            'item_name' => '椅子4個セット',
            'price' => 20000,
            'image' => '/storage/items/chair.jpg',
            'about' => '引っ越しするため出品します！2年ほど使用しており、小さい傷などありますが状態はそこそこ綺麗だと思います！',
        ],
        [
            'id' => 3,
            'user_id' => 3,
            'item_name' => 'コスメまとめ売り',
            'price' => 1000,
            'image' => '/storage/items/cosme.jpg',
            'about' => '某コスメサイトで爆買いしたところ買いすぎて使いきれないためまとめて出品します。新品未使用です！',
        ],
        [
            'id' => 4,
            'user_id' => 4,
            'item_name' => 'ポルシェ',
            'price' => 20000000,
            'image' => '/storage/items/car.jpg',
            'about' => 'ポルシェです。嘘じゃないです。値下げ交渉、返品は受け付けません。',
        ],
        [
            'id' => 5,
            'user_id' => 5,
            'item_name' => 'ダブルベッド',
            'price' => 200000,
            'image' => '/storage/items/bed.jpg',
            'about' => '１ヶ月ほど前に購入したベッドです。2人用のベッドを購入したところ独り身の自分には大きすぎたので出品します、、。シーツなど交換すればほぼ新品の状態で利用できると思います！',
        ],
    ];


    public function definition()
    {
        $item = $this->items[array_rand($this->items)];

        return [
            'user_id' => User::factory()->create()->id,
            'item_name' => $item['item_name'],
            'price' => $item['price'],
            'image' => $item['image'],
            'about' => $item['about'],
        ];
    }

}
