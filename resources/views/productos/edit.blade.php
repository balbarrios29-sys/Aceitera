@extends('layouts.app')

@section('titulo', 'Nuevo producto — Aceitera C5')

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <h2 class="mb-4">Registrar nuevo producto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('productos.store') }}">
        @csrf
        @include('productos._form')
        <button class="btn btn-primary">Guardar producto</button>
        <a href="{{ route('productos.index') }}" class="btn btn-link">Cancelar</a>
    </form>
</div>
@endsection