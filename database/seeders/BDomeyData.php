<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BDomeyData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Nasir Mokresh',
            'email' => 'nasir@sawtru.dev',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole([1]);

        $user = User::create([
            'name' => 'Mohammed Alfarra',
            'email' => 'mohammed_alfarra@sawtru.dev',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole([2]);

        $user = User::create([
            'name' => 'Mohammed Ali',
            'email' => 'mohammed_ali@sawtru.dev',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole([3]);
    }
}
