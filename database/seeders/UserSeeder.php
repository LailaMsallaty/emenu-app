<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'PhenixOwner',
            'email' => 'info@phenixsoft.com',
            'IsOwner'=>1,
            'password' => Hash::make('OwnerOnMenu123@369')
        ]);
    }
}
