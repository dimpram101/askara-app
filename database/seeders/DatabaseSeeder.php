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
        // Create roles first
        $this->call(RoleSeeder::class);

        // Create Dinkes user (admin)
        $dinkes = User::factory()->create([
            'name' => 'Admin Dinkes',
            'email' => 'dinkes@example.com',
        ]);
        $dinkes->assignRole('Dinkes');

        // Create Fasyankes users
        $fasyankes1 = User::factory()->create([
            'name' => 'Fasyankes RS Umum',
            'email' => 'fasyankes1@example.com',
        ]);
        $fasyankes1->assignRole('Fasyankes');

        $fasyankes2 = User::factory()->create([
            'name' => 'Fasyankes Puskesmas',
            'email' => 'fasyankes2@example.com',
        ]);
        $fasyankes2->assignRole('Fasyankes');

        // Create Pasien users
        $pasien1 = User::factory()->create([
            'name' => 'Pasien Test',
            'email' => 'pasien@example.com',
        ]);
        $pasien1->assignRole('Pasien');

        // Create additional users with random roles
        $additionalUsers = User::factory(6)->create();
        $roles = ['Fasyankes', 'Dinkes', 'Pasien'];

        foreach ($additionalUsers as $user) {
            $user->assignRole($roles[array_rand($roles)]);
        }
    }
}
