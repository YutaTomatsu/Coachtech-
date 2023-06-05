<?php

namespace Database\Factories;

use App\Models\ItemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemCategoryFactory extends Factory
{
    protected $model = ItemCategory::class;

    private $categories = [
        ['id' => 1, 'item_id' => '1', 'category_id' => '4'],
        ['id' => 2, 'item_id' => '1', 'category_id' => '10'],
        ['id' => 3, 'item_id' => '2', 'category_id' => '5'],
        ['id' => 4, 'item_id' => '2', 'category_id' => '14'],
        ['id' => 5, 'item_id' => '3', 'category_id' => '7'],
        ['id' => 6, 'item_id' => '3', 'category_id' => '8'],
        ['id' => 7, 'item_id' => '3', 'category_id' => '14'],
        ['id' => 8, 'item_id' => '4', 'category_id' => '9'],
        ['id' => 9, 'item_id' => '5', 'category_id' => '5'],
    ];

    public function definition()
    {
        $category = array_shift($this->categories);

        return [
            'id' => $category['id'],
            'item_id' => $category['item_id'],
            'category_id' => $category['category_id'],
        ];
    }
}
