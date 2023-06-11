<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Admin::factory(1)->create();
        \App\Models\Condition::factory(4)->create();
        \App\Models\Category::factory(14)->create();
        \App\Models\Item::factory(5)->create();
        \App\Models\ItemCategory::factory(9)->create();
        \App\Models\ItemCondition::factory(5)->create();
        \App\Models\Comment::factory(4)->create();
    }
}
