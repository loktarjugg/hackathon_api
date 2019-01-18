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
        $mobile = '111111';
        \App\User::query()->where('mobile', $mobile)->firstOrCreate([
           'name' => 'hackathon',
           'mobile' => $mobile,
           'password' => bcrypt('123456')
        ]);
    }
}
