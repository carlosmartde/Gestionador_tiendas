@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-start">Detalle de Venta #{{ $sale->id }}</h3>
                    <div class="float-end">
                        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Volver a Reportes</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Información de la Venta</h5>
                            <p><strong>ID:</strong> {{ $sale->id }}</p>
                            <p><strong>Usuario:</strong> {{ $sale->user->name }}</p>
                            <p><strong>Fecha y Hora:</strong> {{ $sale->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Total:</strong> Q{{ number_format($sale->total, 2) }}</p>
                        </div>
                    </div>

                    <h5>Productos Vendidos</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->code }}</td>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->product->brand }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Q{{ number_format($detail->price, 2) }}</td>
                                    <td>Q{{ number_format($detail->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total:</th>
                                <th>Q{{ number_format($sale->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection