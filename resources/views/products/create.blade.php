@extends('layouts.app')

@section('title', 'Ingresar Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Ingresar Nuevo Producto</div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Código del Producto</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="brand" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="purchase_price" class="form-label">Precio de Compra</label>
                        <div class="input-group">
                            <span class="input-group-text">Q</span>
                            <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="sale_price" class="form-label">Precio de Venta</label>
                        <div class="input-group">
                            <span class="input-group-text">Q</span>
                            <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="stock" class="form-label">Cantidad en Inventario</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
