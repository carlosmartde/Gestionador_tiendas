@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
<div class="text-center">
    <h1 class="mb-4">¡Bienvenido, {{ Auth::user()->name }}!</h1>
    <p class="lead">¿Qué deseas hacer hoy?</p>
    
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bag-plus fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Ingresar Producto</h5>
                    <p class="card-text">Agrega nuevos productos al inventario</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Ir a Productos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-cart-plus fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Ventas</h5>
                    <p class="card-text">Registra nuevas ventas</p>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary">Ir a Ventas</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Inventario</h5>
                    <p class="card-text">Consulta el stock disponible</p>
                    <a href="{{ route('inventory.index') }}" class="btn btn-primary">Ver Inventario</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-plus-square fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Agregar al Inventario</h5>
                    <p class="card-text">Actualiza stock y precios de productos existentes</p>
                    <a href="{{ route('inventario.mostrar-formulario') }}" class="btn btn-primary">Actualizar Stock</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-bar-graph fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Reporte de ventas</h5>
                    <p class="card-text">Revisa los datos de las ventas realizadas</p>
                    <a href="{{ route('reports.index') }}" class="btn btn-primary">Ver Reportes</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-plus fs-1 mb-3 text-primary"></i>
                    <h5 class="card-title">Crear Usuario</h5>
                    <p class="card-text">Crear nuevos usuarios admin o vendedores</p>
                    <a href="{{ route('register') }}" class="btn btn-primary">Crear Usuario</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection