<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@yaxenceluxe.com'],
            ['name' => 'Admin', 'first_name' => 'Admin', 'last_name' => '', 'password' => 'YaxenceLuxe2026!', 'is_admin' => true]
        );

        $this->call(ProductSeeder::class);
    }
}
