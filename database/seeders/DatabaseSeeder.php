<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\GuruSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@sdn2dermolo.sch.id',
        ], [
            'name' => 'Admin SD N 2 Dermolo',
            'password' => Hash::make('admin12345'),
        ]);

        $this->call(GuruSeeder::class);
    }
}
