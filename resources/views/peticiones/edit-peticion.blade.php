@extends('layouts.public')

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
        @if ($peticion)
            <div class="row">
                <div class="col">
                    <form method="post" action="{{ route('peticiones.update', $peticion->id) }}" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-8">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo" value="{{ old('titulo', $peticion->titulo) }}">
                            @error('titulo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion">{{ old('descripcion', $peticion->descripcion) }}</textarea>
                            @error('descripcion')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="destinatario" class="form-label">Destinatario</label>
                            <textarea name="destinatario" class="form-control @error('destinatario') is-invalid @enderror" id="destinatario" required>{{ old('destinatario', $peticion->destinatario) }}</textarea>
                            @error('destinatario')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <label for="category">Categoría</label>
                            <select name="category" class="form-control" id="category">
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ $peticion->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Sube una imagen</label>
                            <input name="file" type="file" class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <input value="Actualizar petición" type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
