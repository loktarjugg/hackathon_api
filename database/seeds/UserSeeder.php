<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'test@hackathon.io';
        \App\User::query()->where('email', $email)->firstOrCreate([
           'name' => 'hackathon',
           'email' => $email,
           'password' => bcrypt('123456')
        ]);
    }
}
