<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            0 => [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$12$4WUkRaR1dmy.vd/VIdCDuukPZ4.1rNplbZHTsw7jvJobueOCTeULO',
            ],
        ]);
    }
}
