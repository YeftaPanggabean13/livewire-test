<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get customer IDs
        $customers = Customer::all();

        if ($customers->count() < 4) {
             return;
        }

        // Jakarta total > 10M (Andi 1, Budi 2)
        Order::create(['customer_id' => $customers[0]->id, 'total' => 6000000]);
        Order::create(['customer_id' => $customers[1]->id, 'total' => 5000000]);

        // Bandung total <= 10M (Siti 3)
        Order::create(['customer_id' => $customers[2]->id, 'total' => 3000000]);

        // Surabaya total > 10M (Dewi 4)
        Order::create(['customer_id' => $customers[3]->id, 'total' => 12000000]);
    }
}
