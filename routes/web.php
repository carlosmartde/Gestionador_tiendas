<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;

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

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    
    // Rutas accesibles para todos los usuarios autenticados (admin y vendedor)
    Route::get('/product/code/{code}', [SaleController::class, 'searchProductByCode']);
    Route::get('/sales/search/{code}', [SaleController::class, 'searchProductByCode']);
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    
    // Rutas solo para administradores (con verificación manual)
    Route::get('/dashboard', function () {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return view('dashboard');
    })->name('dashboard');

    // Rutas de productos (solo admin)
    Route::get('/products', function () {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'index']);
    })->name('products.index');

    Route::get('/products/create', function () {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'create']);
    })->name('products.create');

    Route::post('/products', function (Illuminate\Http\Request $request) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'store'], ['request' => $request]);
    })->name('products.store');

    Route::get('/products/{product}', function ($product) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'show'], ['product' => $product]);
    })->name('products.show');

    Route::get('/products/{product}/edit', function ($product) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'edit'], ['product' => $product]);
    })->name('products.edit');

    Route::put('/products/{product}', function (Illuminate\Http\Request $request, $product) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'update'], ['request' => $request, 'product' => $product]);
    })->name('products.update');

    Route::delete('/products/{product}', function ($product) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'destroy'], ['product' => $product]);
    })->name('products.destroy');

    Route::get('/product/code/{code}', function ($code) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ProductController::class), 'getProductByCode'], ['code' => $code]);
    })->name('product.code');

    // Rutas de inventario (solo admin)
    Route::get('/inventory', function () {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(InventoryController::class), 'index']);
    })->name('inventory.index');

    Route::get('/inventario/agregar', function () {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(App\Http\Controllers\InventarioController::class), 'mostrarFormularioAgregar']);
    })->name('inventario.mostrar-formulario');

    Route::post('/inventario/actualizar', function (Illuminate\Http\Request $request) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(App\Http\Controllers\InventarioController::class), 'actualizarInventario'], ['request' => $request]);
    })->name('inventario.actualizar');

    Route::get('/inventario/buscar-producto', function (Illuminate\Http\Request $request) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(App\Http\Controllers\InventarioController::class), 'buscarProducto'], ['request' => $request]);
    })->name('inventario.buscar-producto');

    // Rutas de reportes (solo admin)
    Route::get('/reports', function (Illuminate\Http\Request $request) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ReportController::class), 'index'], ['request' => $request]);
    })->name('reports.index');

    Route::get('/reports/{id}', function ($id) {
        if (Auth::user()->rol !== 'admin') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        return app()->call([app(ReportController::class), 'detail'], ['id' => $id]);
    })->name('reports.detail');
});