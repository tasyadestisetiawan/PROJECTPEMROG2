<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Customer;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // data user
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'is_admin' => 1,
            'hp' => '087654321001',
            'password' => bcrypt('P@55word'),
        ]);
        User::create([
            'nama' => 'Sopian Aji',
            'email' => 'sopian4ji@gmail.com',
            'is_admin' => 0,
            'hp' => '087654321001',
            'password' => bcrypt('P@55word'),
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

        // Data Kategori
        Kategori::create([
            'nama_kategori' => 'Cincin',
        ]);
    }
}