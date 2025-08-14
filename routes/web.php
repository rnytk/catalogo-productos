<?php

use App\Http\Controllers\OrderViewController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});¨*/

Route::redirect('/', '/admin');
Route::get('/pedidos', [OrderViewController::class, 'index'])->name('orders.view');