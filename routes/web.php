<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [\App\Http\Controllers\PagesController::class, 'home'])->name('home');
Route::controller(\App\Http\Controllers\PeticioneController::class)->group(function () {
    Route::get('peticiones/index', 'index')->name('peticiones.index');
    Route::get('mispeticiones', 'listMine')->name('peticiones.mine');
    Route::get('peticionesfirmadas', 'peticionesFirmadas')->name('peticiones.peticionesfirmadas');
    Route::get('peticiones/{id}', 'show')->name('peticiones.show');
    Route::get('peticion/add', 'create')->name('peticiones.create');
    Route::post('peticion', 'store')->name('peticiones.store');
    Route::delete('peticiones/{id}', 'dropPeticion')->name('peticiones.delete');
    Route::put('peticiones/{id}', 'update')->name('peticiones.update');
    Route::post('peticiones/firmar/{id}', 'firmar')->name('peticiones.firmar');
    Route::get('peticiones/edit/{id}', 'editPeticion')->name('peticiones.edit');
});

Route::get('/users/firmas', [\App\Http\Controllers\UserController::class,'peticionesFirmadas'])->middleware('auth');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->controller(\App\Http\Controllers\Admin\AdminPeticionesController::class)->group(function () {
    Route::get('admin', 'index')->name('adminpeticiones.home');
    Route::get('admin/peticiones/index', 'index')->name('adminpeticiones.index');
    Route::get('admin/peticiones/{id}', 'show')->name('adminpeticiones.show');
    Route::get('admin/peticion/add', 'create')->name('adminpeticiones.create');
    Route::get('admin/peticiones/edit/{id}', 'editPeticion')->name('adminpeticiones.edit');
    Route::post('admin/peticiones', 'store')->name('adminpeticiones.store');
    Route::delete('admin/peticiones/{id}', 'dropPeticion')->name('adminpeticiones.delete');
    Route::put('admin/peticiones/{id}', 'update')->name('adminpeticiones.update');
    Route::put('admin/peticiones/estado/{id}', 'cambiarEstado')->name('adminpeticiones.estado');
});

Route::middleware('admin')->controller(\App\Http\Controllers\Admin\AdminCategoriasController::class)->group(function () {
    Route::get('admin/categorias/index', 'index')->name('admincategorias.index');
    Route::get('admin/categoria/add', 'create')->name('admincategorias.create');
    Route::get('admin/categorias/edit/{id}', 'editCategoria')->name('admincategorias.edit');
    Route::post('admin/categorias', 'store')->name('admincategorias.store');
    Route::delete('admin/categorias/{id}', 'dropCategoria')->name('admincategorias.delete');
    Route::put('admin/categorias/{id}', 'updateCategoria')->name('admincategorias.update');
});

Route::middleware('admin')->controller(\App\Http\Controllers\Admin\AdminUsersController::class)->group(function () {
    Route::get('admin', 'index')->name('adminusers.home');
    Route::get('admin/users/index', 'index')->name('adminusers.index');
    Route::delete('admin/users/{id}', 'dropUser')->name('adminusers.delete');
    Route::put('admin/users/rol/{id}', 'cambiarRol')->name('adminusers.rol');
});

require __DIR__.'/auth.php';
