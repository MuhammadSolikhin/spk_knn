<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JurusanSeeder::class,   // Harus duluan sebelum DataTraining
            KriteriaSeeder::class,  // Harus duluan sebelum DataTraining
            DataTrainingSeeder::class,
        ]);
    }
}