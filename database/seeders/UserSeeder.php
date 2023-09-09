<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
            'name'          => 'DONI',
            'nip'           => 1234,
            'job_position'  => 'DIREKTUR',
            'password'      => Hash::make('123456'),
        ]);
    }
}
