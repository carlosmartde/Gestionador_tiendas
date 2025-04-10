<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MINI-MARKET - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            /* Nueva paleta de colores moderna */
            --primary-color: #3a86ff;
            --primary-dark: #2667cc;
            --secondary-color: #8338ec;
            --accent-color: #ff006e;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --background-color: #f0f2f5;
            --card-background: #ffffff;
            --sidebar-bg: #212529;
            --sidebar-text: #f8f9fa;
            --sidebar-hover: #3a86ff;
            --sidebar-active: #ff006e;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--background-color);
        }
        
        .content-wrapper {
            display: flex;
            flex: 1;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 20px 0;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 0.75rem 1.25rem;
            border-radius: 5px;
            margin: 0.25rem 0.75rem;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-header {
            padding: 0.75rem 1.25rem;
            color: var(--sidebar-text);
            text-decoration: none;
            display: block;
            font-weight: bold;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-header:hover {
            color: var(--sidebar-hover);
            transform: translateX(5px);
        }
        
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 20px;
            transition: margin-left 0.3s;
        }
        
        /* Estilos cuando el contenido debe ocupar toda la pantalla */
        .main-content.w-100 {
            margin-left: 0;
            width: 100%;
        }
        
        footer {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s;
            background-color: var(--dark-color) !important;
            color: var(--light-color) !important;
        }
        
        /* Estilos de footer cuando debe ocupar toda la pantalla */
        footer.w-100 {
            margin-left: 0;
            width: 100%;
        }
        
        /* Estilos para las cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: var(--card-background);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Estilos para los botones */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Estilos para la navbar */
        .navbar-dark {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }
        
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }
        
        /* Estilos responsivos */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                transition: margin-left 0.3s;
            }
            
            .sidebar.show {
                margin-left: 0;
            }
            
            .main-content, footer {
                margin-left: 0;
                width: 100%;
            }
            
            .main-content.sidebar-open, footer.sidebar-open {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Verifica si estamos en la página de welcome para ajustar clases CSS -->
    @php
        $isWelcomePage = request()->route()->getName() === 'welcome' || request()->path() === '/';
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid d-flex justify-content-center">
            <a class="navbar-brand" href="/dashboard">MINI-MARKET</a>
            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>


    <div class="content-wrapper" style="margin-top: 56px;">
        <!-- Sidebar - solo se muestra si no es la página de welcome y el usuario está autenticado -->
        @auth
        @if(!$isWelcomePage)
        <div class="sidebar">
            <a href="/dashboard" class="sidebar-header">
                <i class="bi bi-house-door"></i> Menu Principal
            </a>
            <ul class="nav flex-column">
                @if(Auth::user()->rol === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}" href="{{ route('products.create') }}">
                        <i class="bi bi-bag-plus"></i> Ingresar Producto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sales.create') ? 'active' : '' }}" href="{{ route('sales.create') }}">
                        <i class="bi bi-cart-plus"></i> Ventas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventory.index') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                        <i class="bi bi-box"></i> Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('inventario.mostrar-formulario') ? 'active' : '' }}" href="{{ route('inventario.mostrar-formulario') }}">
                        <i class="bi bi-plus-square"></i> Agregar al Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="bi bi-file-earmark-bar-graph"></i> Ver Reportes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                        <i class="bi bi-person-plus"></i> Crear Usuario
                    </a>
                </li>
                @endif
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST" class="px-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endif
        @endauth

        <!-- Main content - ajusta las clases según si es la página de welcome -->
        <main class="main-content {{ $isWelcomePage ? 'w-100 m-0' : '' }}">
            @yield('content')
        </main>
    </div>

    <footer class="text-center py-3 {{ $isWelcomePage ? 'w-100 m-0' : '' }}">
        <p class="m-0">MINI-MARKET &copy; {{ date('Y') }}</p>
    </footer>

    <script>
        // Toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const footer = document.querySelector('footer');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    mainContent.classList.toggle('sidebar-open');
                    footer.classList.toggle('sidebar-open');
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>