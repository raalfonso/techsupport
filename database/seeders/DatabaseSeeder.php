<?php

namespace Database\Seeders;

use App\Models\Issues;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Issues::factory(25)->create();
        Category::factory(25)->create();
    }
}
