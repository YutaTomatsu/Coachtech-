<?php

namespace Database\Factories;

use App\Models\ItemCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemConditionFactory extends Factory
{
    protected $model = ItemCondition::class;

    private $conditions = [
        ['id' => 1, 'item_id' => '1', 'condition_id' => '4'],
        ['id' => 2, 'item_id' => '2', 'condition_id' => '3'],
        ['id' => 3, 'item_id' => '3', 'condition_id' => '1'],
        ['id' => 4, 'item_id' => '4', 'condition_id' => '1'],
        ['id' => 5, 'item_id' => '5', 'condition_id' => '2'],
    ];

    public function definition()
    {
        $condition = array_shift($this->conditions);

        return [
            'id' => $condition['id'],
            'item_id' => $condition['item_id'],
            'condition_id' => $condition['condition_id'],
        ];
    }
}
