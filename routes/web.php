<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\UserTable;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', UserTable::class);
