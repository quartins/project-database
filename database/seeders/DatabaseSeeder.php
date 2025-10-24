<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       $this->call([
    CategorySeeder::class,
    ProductSeeder::class,
    AttributeSeeder::class,
    BulkProductDetailsSeeder::class,
]);

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'username'  => 'testuser',
                'firstname' => 'Test',
                'lastname'  => 'User',
                'password'  => bcrypt('password'),
            ]
        );
    }
}
