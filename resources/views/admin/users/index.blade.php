@extends('layouts.admin')

@section('content')
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Users</h4>
        </div>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>
                    @if ($user->role == 1)
                        admin
                    @else
                        user
                    @endif
                </td>
                <td>
                <form action="{{route('adminusers.rol', $user->id)}}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-shift-fill"></i>
                    </button>
                </form>
                <form action="{{route('adminusers.delete', $user->id)}}" method="POST" style="display:inline;">
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
