<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->delete();
        DB::table('clients')->insert([
            0 => [
                'name' => 'Metrobank',
                'code' => 'code1',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            1 => [
                'name' => 'BPI Bank',
                'code' => 'code2',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            2 => [
                'name' => 'Union Bank',
                'code' => 'code3',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            3 => [
                'name' => 'PS Bank',
                'code' => 'code4',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            4 => [
                'name' => 'BDO Bank',
                'code' => 'code5',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            5 => [
                'name' => 'Landbank',
                'code' => 'code6',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            6 => [
                'name' => 'China Bank',
                'code' => 'code7',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
            7 => [
                'name' => 'UCPB Bank',
                'code' => 'code8',
                'branch' => 'branch1',
                'address' => 'bank address 1',
                'user_id' => 1,
            ],
        ]);
    }
}
