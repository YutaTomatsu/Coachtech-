<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{

    protected $model = Category::class;

    private $categories = [
        ['id' => 1, 'category' => '洋服'],
        ['id' => 2, 'category' => 'メンズ'],
        ['id' => 3, 'category' => 'レディース'],
        ['id' => 4, 'category' => '小物'],
        ['id' => 5, 'category' => '家具'],
        ['id' => 6, 'category' => '家電'],
        ['id' => 7, 'category' => '美容'],
        ['id' => 8, 'category' => 'コスメ'],
        ['id' => 9, 'category' => '車'],
        ['id' => 10, 'category' => 'ホビー'],
        ['id' => 11, 'category' => '本'],
        ['id' => 12, 'category' => 'ゲーム'],
        ['id' => 13, 'category' => 'チケット'],
        ['id' => 14, 'category' => 'まとめ売り'],
    ];

    public function definition()
    {
        $category = array_shift($this->categories);

        return [
            'id' => $category['id'],
            'category' => $category['category'],
        ];
    }
}
