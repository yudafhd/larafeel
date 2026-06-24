<?php

use Illuminate\Support\Facades\Route;
use Yudafhd\Larafeel\Http\Middleware\LarafeelApiMiddleware;

Route::get('/larafeel-docs', function () {
    return view('larafeel::docs');
})->middleware([
    'web',
    LarafeelApiMiddleware::class,
]);
