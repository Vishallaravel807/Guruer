<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([

            'name' => 'Vishal',

            'email' => 'admin@gmail.com',

            'password' => bcrypt('12345678'),

        ]);
    }
}
