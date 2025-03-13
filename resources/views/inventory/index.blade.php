<!-- resources/views/inventory/index.blade.php -->
@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Inventario de Productos</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <input type="text" id="search-input" class="form-control" placeholder="Buscar por nombre o código...">
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="inventory-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th>Estado</th>
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

                        <td>
                            <a href="{{ route('inventario.mostrar-formulario', ['product' => $product->id, 'codigo' => $product->code]) }}" class="btn btn-sm btn-primary"> 
                                <i class="bi bi-pencil"></i>
                            </a>                      
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay productos en el inventario</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const table = document.getElementById('inventory-table');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            
            for (let i = 0; i < rows.length; i++) {
                const code = rows[i].cells[0].textContent.toLowerCase();
                const name = rows[i].cells[1].textContent.toLowerCase();
                
                if (code.indexOf(term) > -1 || name.indexOf(term) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>
@endsection