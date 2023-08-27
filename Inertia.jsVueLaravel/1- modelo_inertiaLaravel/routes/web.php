<?php

use App\Http\Controllers\loginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreelancersController;
use Inertia\Inertia;

Route::get('/', [FreelancersController::class, 'index']);
Route::get('/menu1', [FreelancersController::class, 'menu1']);
Route::get('/pagina01', [FreelancersController::class, 'pagina01']);

Route::get('/login', [loginController::class, 'index']);



Route::get('/{any}', function () {
    return Inertia::render('errors/NotFound');
})->where('any', '^(?!api).*$');
