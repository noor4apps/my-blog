<?php

namespace Database\seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'un-categorized', 'status' => 1]);
        Category::create(['name' => 'Natural', 'status' => 1]);
        Category::create(['name' => 'Flowers', 'status' => 1]);
        Category::create(['name' => 'Kitchen', 'status' => 0]);
    }
}