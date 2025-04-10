@extends('layouts.app')

@section('title', 'Ingresar Producto')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="bi bi-bag-plus me-2"></i>Ingresar Nuevo Producto
        </h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>¡Error!</strong> Por favor corrige los siguientes errores:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            
            <div class="mb-3">
                <label for="code" class="form-label fw-bold">Código del Producto</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Nombre del Producto</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="brand" class="form-label fw-bold">Marca</label>
                <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="purchase_price" class="form-label fw-bold">Precio de Compra</label>
                <div class="input-group">
                    <span class="input-group-text">Q</span>
                    <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="sale_price" class="form-label fw-bold">Precio de Venta</label>
                <div class="input-group">
                    <span class="input-group-text">Q</span>
                    <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="stock" class="form-label fw-bold">Cantidad en Inventario</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Guardar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection