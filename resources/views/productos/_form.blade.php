<div class="mb-3">
    <label class="form-label">Código</label>
    <input type="text" name="codigo" value="{{ old('codigo', $producto->codigo ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Categoría</label>
    <input type="text" name="categoria" value="{{ old('categoria', $producto->categoria ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Marca</label>
    <input type="text" name="marca" value="{{ old('marca', $producto->marca ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Presentación</label>
    <input type="text" name="presentacion" value="{{ old('presentacion', $producto->presentacion ?? '') }}" class="form-control" required>
</div>
<div class="row">
    <div class="col mb-3">
        <label class="form-label">Precio de venta</label>
        <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio ?? '') }}" class="form-control" required>
    </div>
    <div class="col mb-3">
        <label class="form-label">Precio de costo</label>
        <input type="number" step="0.01" name="precio_costo" value="{{ old('precio_costo', $producto->precio_costo ?? '') }}" class="form-control" required>
    </div>
</div>
<div class="row">
    <div class="col mb-3">
        <label class="form-label">Stock actual</label>
        <input type="number" name="stock_actual" value="{{ old('stock_actual', $producto->stock_actual ?? '') }}" class="form-control" required>
    </div>
    <div class="col mb-3">
        <label class="form-label">Stock mínimo</label>
        <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo ?? '') }}" class="form-control" required>
    </div>
</div>