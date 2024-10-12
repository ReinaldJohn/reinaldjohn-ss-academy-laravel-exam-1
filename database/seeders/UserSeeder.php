<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'prefixname' => 'Mr.',
            'firstname' => 'Reinald John',
            'middlename' => '',
            'lastname' => 'Vibar',
            'suffixname' => '',
            'username' => 'reinaldvibar',
            'email' => 'reinaldjohnvibar@gmail.com',
            'password' => Hash::make('zapzero16'),
            'photo' => null,
            'type' => 'admin',
            'remember_token' => Str::random(10),
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null,
        ]);
    }
}