@php
    use Illuminate\Support\Facades\Auth;
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background: #f33b3b;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            display: block;
        }
        .sidebar a:hover {
            background: #c32f2f;
        }
        .table-container {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-white fw-bold mb-4">Change.org</h4>
        <div class="text-center mb-4">
            <img src="https://via.placeholder.com/50" class="rounded-circle" alt="Admin">
            <p class="mt-2">Panel de admin</p>
        </div>
        <nav>
            <a href="{{route('adminpeticiones.index')}}" class="mb-2"><i class="bi bi-list-check"></i>Peticiones</a>
            <a href="{{route('admincategorias.index')}}" class="mb-2"><i class="bi bi-list-check"></i>Categorias</a>
            <a href="{{route('adminusers.index')}}" class="mb-2"><i class="bi bi-list-check"></i>Usuarios</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1">
        <!-- Content Section -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
