<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_sampahs')->truncate();
        DB::table('jenis_sampahs')->insert([
            [
                'jenis_sampah'   => 'Organik',
            ],
            [
                'jenis_sampah'   => 'Anorganik',
            ],
            [
                'jenis_sampah'   => 'Berbahaya',
            ],
        ]);
    }
}
