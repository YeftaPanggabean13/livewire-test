<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create(['name' => 'Andi', 'city' => 'Jakarta']);
        Customer::create(['name' => 'Budi', 'city' => 'Jakarta']);
        Customer::create(['name' => 'Siti', 'city' => 'Bandung']);
        Customer::create(['name' => 'Dewi', 'city' => 'Surabaya']);
    }
}
