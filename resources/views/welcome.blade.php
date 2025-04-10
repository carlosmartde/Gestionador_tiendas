@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="py-5 my-5">
                <h1 class="display-4 mb-4">Bienvenido a MINI-MARKET</h1>
                <p class="lead">Sistema de gestión para tienda de abarrotes</p>
                @guest
                <div class="mt-5">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-3">Iniciar Sesión</a>
                </div>
                @else
                <div class="mt-5">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">INGRESAR A LA TIENDA EN LINEA</a>
                </div>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection