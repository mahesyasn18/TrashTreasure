<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DropPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drop_points')->truncate();
        DB::table('drop_points')->insert([
            [
                'nama'   => 'Drop Point 1',
                'alamat' => 'Ciwaruga'
            ],
            [
                'nama'   => 'Drop Point 2',
                'content' => 'Sarijadi'
            ],
            [
                'nama'   => 'Drop Point 3',
                'content' => 'Geger Kalong'
            ],
        ]);
    }
}
