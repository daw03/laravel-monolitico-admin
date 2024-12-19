@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <form action="{{route('admincategorias.update',$categoria->id)}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $categoria->id }}">
                    @csrf
                    @method('put')
                    <div class="col-md-8">
                        <label for="validationServer01" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="validationServer01" value="{{ old('titulo', $categoria->nombre) }}">
                        @error('nombre')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <input value="Enviar categoria nueva" type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
