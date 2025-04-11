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
                      
                        <div class="col-md-3">
                            <label for="fecha" class="form-label ">Fecha</label>
                            <input type="text" class="form-control datepicker" name="fecha" id="fecha" value="{{ $date }}">
                        </div>
                         
                    
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

                    <div class="row mb-3">

<!-- Total en ventas -->
<div class="col-md-4 mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h6 class="card-title text-muted">Total en ventas</h6>
            <h4 class="text-primary">Q{{ number_format($sales->sum('total'), 2) }}</h4>
        </div>
    </div>
</div>

<!-- Total en costos -->
<div class="col-md-4 mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h6 class="card-title text-muted">Total en costos</h6>
            <h4 class="text-warning">Q{{ number_format($totalCost, 2) }}</h4>
        </div>
    </div>
</div>

<!-- Ganancias -->
<div class="col-md-4 mb-3">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">
            <h6 class="card-title text-muted">Ganancias</h6>
            <h4 class="text-success">Q{{ number_format($totalProfit, 2) }}</h4>
        </div>
    </div>
</div>
                    <!-- Gráfico de ventas 
                        
                   se tiene que ver en dias(horas), semanas(dias), meses(semanas), años(meses) 
                    <div class="mb-4">
                        <canvas id="salesChart" style="height: 400px;"></canvas>
                    </div>

                -->

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

                        </table>
                        <!-- Paginación estilo Bootstrap -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $sales->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>
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