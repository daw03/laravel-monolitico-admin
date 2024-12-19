@extends('layouts.admin')

@section('content')
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Categorias</h4>
            <a href="{{route('admincategorias.create')}}" class="btn btn-primary">Nueva categoria</a>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($categorias as $categoria)
                <tr>
                <td>{{$categoria->id}}</td>
                <td>{{$categoria->nombre}}</td>
                <td>
                    <a href="{{ route('admincategorias.edit', $categoria->id) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{route('admincategorias.delete', $categoria->id)}}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
