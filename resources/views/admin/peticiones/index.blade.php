@extends('layouts.admin')

@section('content')
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Peticiones</h4>
            <a href="{{route('adminpeticiones.create')}}" class="btn btn-primary">Nueva petición</a>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Firmantes</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($peticiones as $peticion)
                <tr>
                <td>{{$peticion->id}}</td>
                <td>{{$peticion->titulo}}</td>
                <td>{{$peticion->firmantes}}</td>
                <td>{{$peticion->estado}}</td>
                <td>
                    <a href="{{route('adminpeticiones.show',$peticion->id)}}" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                    <form action="{{ route('adminpeticiones.estado', $peticion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="bi bi-check"></i>
                        </button>
                    </form>

                    <a href="{{ route('adminpeticiones.edit', $peticion->id) }}" class="btn btn-success btn-sm">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{route('adminpeticiones.delete', $peticion->id)}}" method="POST" style="display:inline;">
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
