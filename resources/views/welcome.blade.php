@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Bienvenido a MINI-MARKET</h1>
    <p class="lead">Sistema de gestión para tienda de abarrotes</p>
    @guest
    <div class="mt-5">
        <a href="{{ route('login') }}" class="btn btn-primary me-3">Iniciar Sesión</a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary">Registrarse</a>
    </div>
    @else
    <div class="mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">INGRESAR A LA TIENDA EN LINEA</a>
    </div>
    @endguest
</div>
@endsection