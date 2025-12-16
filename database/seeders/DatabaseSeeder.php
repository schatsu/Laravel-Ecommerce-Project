<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $superAdmin = User::query()->create([
//            'name' => 'Ata Ziya',
//            'surname' => 'Şireci',
//            'slug' => 'ata-ziya-sireci',
//            'email' => 'atasireci@gmail.com',
//            'password' => Hash::make('password'),
//            'email_verified_at' => now(),
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);

        $this->call([
//           CategorySeeder::class,
//           CountrySeeder::class,
            CountrySeeder::class,
        ]);
    }
}
