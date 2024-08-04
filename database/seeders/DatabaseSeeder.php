<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // data user
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => 'superadmin',
            'hp' => '087654321001',
            'password' => Hash::make('P@55word'),
        ]);
        User::create([
            'nama' => 'Tasya',
            'email' => 'tasya@gmail.com',
            'role' => 'admin',
            'hp' => '087654321001',
            'password' => Hash::make('P@55word'),
        ]);
        // data customer
        Customer::create([
            'nama_customer' => 'Ria Triana',
            'email' => 'ria@gmail.com',
            'hp' => '087654321003',
        ]);
        Customer::create([
            'nama_customer' => 'Melly Agustin',
            'email' => 'melly@gmail.com',
            'hp' => '087654321004',
        ]);
    }
}