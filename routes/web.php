<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function(){
    return view('index');
});

Route::post('/', [BookController::class, 'store'])->name('crud.store');



