<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', function () {
    return view('pages.products.index');
});

Route::get('/products/{id}', function ($id) {
    return view('pages.products.show', ['id' => $id]);
});
