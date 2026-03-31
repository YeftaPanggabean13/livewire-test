<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityOrderReportController extends Controller
{
    public function index()
    {
        // Query Eloquent for Soal 2
        $results = Customer::join('orders', 'customers.id', '=', 'orders.customer_id')
            ->select(
                'customers.city',
                DB::raw('COUNT(orders.id) as total_order'),
                DB::raw('SUM(orders.total) as total_nominal')
            )
            ->groupBy('customers.city')
            ->having('total_nominal', '>', 10000000)
            ->get();

        return view('city-report', compact('results'));
    }
}
