<?php

use Illuminate\Database\Seeder;
use App\WhiteAddress;

class WhiteAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = File::get(storage_path('data.json'));
        $lists = json_decode($lists, true);

        foreach ($lists as $address => $name) {
            WhiteAddress::create([
                'address' => strtolower($address),
                'name' => $name
            ]);
        }
    }
}
