<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;

// Rutas públicas
Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/product/code/{code}', [SaleController::class, 'searchProductByCode']);
Route::get('/sales/search/{code}', [SaleController::class, 'searchProductByCode']);use App\Http\Controllers\InventarioController;
Route::get('/inventario/agregar', [InventarioController::class, 'mostrarFormularioAgregar'])->name('inventario.mostrar-formulario');
Route::post('/inventario/actualizar', [InventarioController::class, 'actualizarInventario'])->name('inventario.actualizar');
Route::get('/inventario/buscar-producto', [InventarioController::class, 'buscarProducto'])->name('inventario.buscar-producto');


// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de productos
    Route::resource('products', ProductController::class);
    Route::get('/product/code/{code}', [ProductController::class, 'getProductByCode'])->name('product.code');

    // Rutas de ventas
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    // Rutas de inventario
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    
});