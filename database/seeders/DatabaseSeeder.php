<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => '048836743@ecampus.ut.ac.id'],
            [
                'name' => 'Muhammad Raka Haikal',
                'password' => Hash::make('048836743'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );
        User::firstOrCreate(
            ['email' => '049307343@ecampus.ut.ac.id'],
            [
                'name' => 'Fajar Kurniawan',
                'password' => Hash::make('049307343'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );
        User::firstOrCreate(
            ['email' => '051954279@ecampus.ut.ac.id'],
            [
                'name' => 'Jerry Kurniawan',
                'password' => Hash::make('051954279'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );
        User::firstOrCreate(
            ['email' => '043419583@ecampus.ut.ac.id'],
            [
                'name' => 'Nandito Nanda Maulana',
                'password' => Hash::make('043419583'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );
        User::firstOrCreate(
            ['email' => '048621355@ecampus.ut.ac.id'],
            [
                'name' => 'TB Moch Rizki Fauzi',
                'password' => Hash::make('048621355'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );


        User::firstOrCreate(
            ['email' => 'admin@tripkuy.test'],
            [
                'name' => 'Admin TripKuy',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        User::firstOrCreate(
            ['email' => 'user@tripkuy.test'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
        );

        $this->call(TripSeeder::class);
        $this->call(PostSeeder::class);
    }
}
