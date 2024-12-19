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
                <form method="post" action="{{route('admincategorias.store')}}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-8">
                        <label for="validationServer01" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="validationServer01">
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
