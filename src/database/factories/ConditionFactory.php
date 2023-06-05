<?php

namespace Database\Factories;

use App\Models\Condition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionFactory extends Factory
{
    protected $model = Condition::class;

    private $conditions = [
        ['id' => 1, 'condition' => '新品、未使用'],
        ['id' => 2, 'condition' => '未使用に近い'],
        ['id' => 3, 'condition' => 'やや傷や汚れあり'],
        ['id' => 4, 'condition' => '状態が悪い'],
    ];

    public function definition()
    {
        $condition = array_shift($this->conditions);

        return [
            'id' => $condition['id'],
            'condition' => $condition['condition'],
        ];
    }
}
