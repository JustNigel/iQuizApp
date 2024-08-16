<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Nigel',
            'last_name' => 'Camba',
            'email' => 'trainer@imedia.com',
            'password' => Hash::make('trainer'), 
            'type_name' => 'trainer',
        ]);
    }
}
