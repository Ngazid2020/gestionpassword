<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $organisation1 = Organisation::factory()->create([
            'name' => 'Test Organisation 1',
            'slug' => 'test-organisation-1',
        ]);
        $organisation2 = Organisation::factory()->create([
            'name' => 'Test Organisation 2',
            'slug' => 'test-organisation-2',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
        ]);

        User::where('id',1)->first()->organisations()->attach($organisation1);
        User::where('id',1)->first()->organisations()->attach($organisation2);
    }
}
