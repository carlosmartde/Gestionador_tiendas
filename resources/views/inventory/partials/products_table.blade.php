<!-- resources/views/inventory/partials/products_table.blade.php -->
<table class="table table-striped table-hover" id="inventory-table">
    <thead>
        <tr>
            <th>Código</th>
            <th>Producto</th>
            <th>Marca</th>
            <th>Precio Compra</th>
            <th>Precio Venta</th>
            <th>Stock</th>
            <th>Estado</th>
            <th colspan="2" class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->brand }}</td>
                <td>Q{{ number_format($product->purchase_price, 2) }}</td>
                <td>Q{{ number_format($product->sale_price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if ($product->stock > 10)
                        <span class="badge bg-success">Disponible</span>
                    @elseif ($product->stock > 0)
                        <span class="badge bg-warning text-dark">Bajo Stock</span>
                    @else
                        <span class="badge bg-danger">Agotado</span>
                    @endif
                </td>

                <td class="text-center">
                    <a href="{{ route('inventario.mostrar-formulario', ['product' => $product->id, 'codigo' => $product->code]) }}"
                        class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No hay productos en el inventario</td>
            </tr>
        @endforelse
    </tbody>
</table>
<!-- Paginación estilo Bootstrap -->
<div class="d-flex justify-content-center mt-4">
    {{ $products->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
</div>