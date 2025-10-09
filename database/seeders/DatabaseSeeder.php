<?php

namespace Database\Seeders;

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
        //  เรียกใช้ Seeder ทั้งหมด
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        //  เพิ่ม user สำหรับทดสอบ login
       User::factory()->create([
            'username' => 'testuser',
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
        ]);
    }
}
