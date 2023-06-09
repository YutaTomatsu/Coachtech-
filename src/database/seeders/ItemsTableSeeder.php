<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemCondition;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $fixedItem = [
            'user_id' => 1,
            'item_name' => 'テディベア',
            'price' => 500,
            'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/bear.jpg',
            'about' => '娘が昔所有していたものですが、娘が成長し、不要になったため売りに出します。',
            'categories' => [4, 10],
            'conditions' => [4],
        ];

        $this->createItem($fixedItem);

        for ($i = 1; $i < 30; $i++) {
            $items =     [
                [
                    'user_id' => rand(1, 10),
                    'item_name' => 'テディベア',
                    'price' => 500,
                    'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/bear.jpg',
                    'about' => '娘が昔所有していたものですが、娘が成長し、不要になったため売りに出します。',
                    'categories' => [4, 10],
                    'conditions' => [4],
                ],
                [
                    'user_id' => rand(1, 10),
                    'item_name' => '椅子4個セット',
                    'price' => 20000,
                    'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/chair.jpg',
                    'about' => '引っ越しするため出品します！2年ほど使用しており、小さい傷などありますが状態はそこそこ綺麗だと思います！',
                    'categories' => [5, 14],
                    'conditions' => [3],
                ],
                [
                    'user_id' => rand(1, 10),
                    'item_name' => 'コスメまとめ売り',
                    'price' => 1000,
                    'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/cosme.jpg',
                    'about' => '某コスメサイトで爆買いしたところ買いすぎて使いきれないためまとめて出品します。新品未使用です！',
                    'categories' => [7, 8, 14],
                    'conditions' => [1],
                ],
                [
                    'user_id' => rand(1, 10),
                    'item_name' => 'ポルシェ',
                    'price' => 9999999,
                    'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/car.jpg',
                    'about' => 'ポルシェです。嘘じゃないです。値下げ交渉、返品は受け付けません。',
                    'categories' => [9],
                    'conditions' => [1],
                ],
                [
                    'user_id' => rand(1, 10),
                    'item_name' => 'ダブルベッド',
                    'price' => 200000,
                    'image' => 'https://flea-market-bucket.s3.ap-northeast-1.amazonaws.com/items_image/bed.jpg',
                    'about' => '１ヶ月ほど前に購入したベッドです。2人用のベッドを購入したところ独り身の自分には大きすぎたので出品します、、。シーツなど交換すればほぼ新品の状態で利用できると思います！',
                    'categories' => [5],
                    'conditions' => [2],
                ],
            ];

            $itemData = $items[array_rand($items)];

            $this->createItem($itemData);
        }
    }

    private function createItem($itemData)
    {
        $item = Item::create([
            'user_id' => $itemData['user_id'],
            'item_name' => $itemData['item_name'],
            'price' => $itemData['price'],
            'image' => $itemData['image'],
            'about' => $itemData['about'],
        ]);

        foreach ($itemData['categories'] as $categoryId) {
            ItemCategory::create([
                'item_id' => $item->id,
                'category_id' => $categoryId,
            ]);
        }

        foreach ($itemData['conditions'] as $conditionId) {
            ItemCondition::create([
                'item_id' => $item->id,
                'condition_id' => $conditionId,
            ]);
        }
    }
}
