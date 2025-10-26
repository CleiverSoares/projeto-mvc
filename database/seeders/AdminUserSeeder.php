<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'cleiversoares2@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'cleiversoares2@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );
        
        $this->command->info('✅ Usuário admin criado: cleiversoares2@gmail.com');
    }
}
