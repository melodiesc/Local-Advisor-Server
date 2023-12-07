<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->create(['category' => 'Hôtel']);
        Category::factory()->create(['category' => 'Bar']);
        Category::factory()->create(['category' => 'Restaurant']);
    }
}
