@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agregar al Inventario</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="codigo" class="form-label">Buscar producto por código:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="codigo" placeholder="Ingrese código del producto">
                            <button class="btn btn-primary" id="buscarBtn">Buscar</button>
                        </div>
                        <div id="error-mensaje" class="text-danger mt-2 d-none"></div>
                    </div>

                    <form id="formActualizar" action="{{ route('inventario.actualizar') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="producto_id" id="producto_id">
                        
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto:</label>
                            <div id="nombre_producto" class="form-control-plaintext"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Stock Actual:</label>
                                <div id="stock_actual" class="form-control-plaintext"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precio de Compra Actual:</label>
                                <div id="precio_compra_actual" class="form-control-plaintext"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad_nueva" class="form-label">Cantidad a Agregar:</label>
                            <input type="number" class="form-control" id="cantidad_nueva" name="cantidad_nueva" min="1" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="precio_compra" class="form-label">Nuevo Precio de Compra:</label>
                                <input type="number" step="0.01" class="form-control" id="precio_compra" name="precio_compra" required>
                            </div>
                            <div class="col-md-6">
                                <label for="precio_venta" class="form-label">Nuevo Precio de Venta:</label>
                                <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Actualizar Inventario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buscarBtn = document.getElementById('buscarBtn');
    const codigoInput = document.getElementById('codigo');
    const formActualizar = document.getElementById('formActualizar');
    const errorMensaje = document.getElementById('error-mensaje');

    // Obtener parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const codigoDesdeURL = params.get('codigo');

    if (codigoDesdeURL) {
        codigoInput.value = codigoDesdeURL; // Rellenar el campo con el código recibido
        buscarProducto(codigoDesdeURL); // Ejecutar la búsqueda automáticamente
    }

    buscarBtn.addEventListener('click', function() {
        const codigo = codigoInput.value.trim();
        if (!codigo) {
            mostrarError('Debe ingresar un código de producto');
            return;
        }
        buscarProducto(codigo);
    });

    function buscarProducto(codigo) {
        fetch(`{{ route('inventario.buscar-producto') }}?codigo=${codigo}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarProducto(data.producto);
                } else {
                    mostrarError(data.mensaje);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarError('Ocurrió un error al buscar el producto');
            });
    }

    function mostrarProducto(producto) {
        document.getElementById('producto_id').value = producto.id;
        document.getElementById('nombre_producto').textContent = producto.nombre;
        document.getElementById('stock_actual').textContent = producto.stock;
        document.getElementById('precio_compra_actual').textContent = `Q${producto.precio_compra}`;
        
        document.getElementById('precio_compra').value = producto.precio_compra;
        document.getElementById('precio_venta').value = producto.precio_venta;
        
        errorMensaje.classList.add('d-none');
        formActualizar.classList.remove('d-none');
    }

    function mostrarError(mensaje) {
        errorMensaje.textContent = mensaje;
        errorMensaje.classList.remove('d-none');
        formActualizar.classList.add('d-none');
    }
});
</script>
@endsection
