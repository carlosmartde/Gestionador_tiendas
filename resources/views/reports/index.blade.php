@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="float-start">Reporte de Ventas</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Formulario de filtros -->
                    <form action="{{ route('reports.index') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="period" class="form-label">Período</label>
                            <select name="period" id="period" class="form-select">
                                <option value="day" {{ $period == 'day' ? 'selected' : '' }}>Día</option>
                                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Semana</option>
                                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Mes</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Año</option>
                            </select>
                        </div>
                        <!--
                        <div class="col-md-3">
                            <label for="fecha" class="form-label fw-bold">Fecha</label>
                            <input type="text" class="form-control datepicker" name="fecha" id="fecha" value="{{ $date }}">
                        </div>
                         -->
                    
                        <div class="col-md-3">
                            <label for="user_id" class="form-label">Usuario</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="all">Todos los usuarios</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $userId == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary ms-2">Reiniciar</a>
                        </div>
                    </form>

                    <!-- Tabla de resultados -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Monto Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->user_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s') }}</td>
                                        <td>Q{{ number_format($sale->total, 2) }}</td>
                                        <td>
                                            <a href="{{ route('reports.detail', $sale->id) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No hay ventas registradas en este período</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>Q{{ number_format($sales->sum('total'), 2) }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Opcional: Para enviar el formulario automáticamente al cambiar cualquier filtro
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.querySelector('form');
        const filterInputs = filterForm.querySelectorAll('select, input[type=date]');
        
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                filterForm.submit();
            });
        });
    });
</script>
@endsection