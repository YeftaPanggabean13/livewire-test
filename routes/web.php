<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserTable;
use App\Http\Controllers\CityOrderReportController;

Route::get('/', function () {
    return redirect('/users');
});

Route::get('/users', UserTable::class);
Route::get('/city-report', [CityOrderReportController::class, 'index']);
