<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $nbrOfUsers = 10;
        User::factory($nbrOfUsers)->create();
        $this->call(CategorySeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(LocationSeeder::class);
    }
}
