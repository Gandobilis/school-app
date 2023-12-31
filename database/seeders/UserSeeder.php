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
        $data = [
            'name' => "Admin Adminadze",
            'email' => "admin@gmail.com",
            'password' => Hash::make('admin'),
        ];
        User::insert($data);
        $data['email'] = 'lashadeveloper@gmail.com';
        $data['role'] = 'admin';
        User::insert($data);
    }
}
