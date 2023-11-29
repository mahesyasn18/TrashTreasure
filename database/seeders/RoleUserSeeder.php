<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->truncate();
        DB::table('role_users')->insert([
            [
                'role_name'   => 'Admin',
            ],
            [
                'role_name'   => 'Pembuang Sampah',
            ],
        ]);
    }
}
