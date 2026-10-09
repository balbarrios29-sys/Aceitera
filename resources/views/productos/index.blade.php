@extends('layouts.app')

@section('titulo', 'Inventario — Aceitera C5')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Inventario</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">+ Nuevo producto</a>
    </div>

    @if (session('exito'))
        <div class="alert alert-success">{{ session('exito') }}</div>
    @endif

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre o código">
        </div>
        <div class="col-auto">
            <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat }}" @selected(request('categoria') == $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary">Filtrar</button>
        </div>
    </form>

    <table class="table table-bordered bg-white">
        <thead class="table-primary">
            <tr>
                <th>Código</th><th>Nombre</th><th>Categoría</th><th>Marca</th>
                <th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $p)
                <tr>
                    <td>{{ $p->codigo }}</td>
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->categoria }}</td>
                    <td>{{ $p->marca }}</td>
                    <td>Q{{ number_format($p->precio, 2) }}</td>
                    <td>{{ $p->stock_actual }}</td>
                    <td>
                        @if ($p->estaEnStockBajo())
                            <span class="badge bg-danger">Stock bajo</span>
                        @else
                            <span class="badge bg-success">Normal</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('productos.edit', $p) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        <form action="{{ route('productos.destroy', $p) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar este producto?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">No hay productos registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection