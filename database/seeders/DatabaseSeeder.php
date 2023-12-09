<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TagSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(NewsTagSeeder::class);
        $this->call(DropPointSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(JenisSampahSeeder::class);
    }
}
