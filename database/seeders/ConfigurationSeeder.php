<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Configuration::insert([
            ['uuid_user' => '0000', 'clave' => 'logo', 'valor' => '/img/logo3.png'],
            ['uuid_user' => '0000', 'clave' => 'color_navbar', 'valor' => '#1f2937'], // gray-800
            ['uuid_user' => '0000', 'clave' => 'color_sidebar', 'valor' => '#111827'],
            ['uuid_user' => '0000', 'clave' => 'color_body', 'valor' => '#ffff'],
        ]);
    }
}
