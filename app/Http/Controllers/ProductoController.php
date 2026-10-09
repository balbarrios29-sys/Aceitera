<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Listar / buscar / filtrar
    public function index(Request $request)
    {
        $query = Producto::query();

        if ($request->filled('buscar')) {
            $texto = $request->buscar;
            $query->where(function ($q) use ($texto) {
                $q->where('nombre', 'like', "%$texto%")
                  ->orWhere('codigo', 'like', "%$texto%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $productos = $query->orderBy('nombre')->get();
        $categorias = Producto::select('categoria')->distinct()->pluck('categoria');

        return view('productos.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        return view('productos.create');
    }

    // Registrar
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'nullable|string|max:30|unique:producto,codigo',
            'nombre' => 'required|string|max:100',
            'categoria' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'presentacion' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'precio_costo' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $producto = Producto::create($datos);

        Movimiento::registrar('Producto', $producto->id_producto, 'producto_creado',
            "Se registró el producto \"{$producto->nombre}\"");

        return redirect()->route('productos.index')->with('exito', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    // Editar (incluye ajuste de stock)
    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'codigo' => 'nullable|string|max:30|unique:producto,codigo,' . $producto->id_producto . ',id_producto',
            'nombre' => 'required|string|max:100',
            'categoria' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'presentacion' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'precio_costo' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $producto->update($datos);

        Movimiento::registrar('Producto', $producto->id_producto, 'producto_editado',
            "Se editó el producto \"{$producto->nombre}\"");

        $mensaje = 'Producto actualizado correctamente.';
        if ($producto->estaEnStockBajo()) {
            Movimiento::registrar('Producto', $producto->id_producto, 'stock_bajo',
                "Stock bajo: \"{$producto->nombre}\" quedó en {$producto->stock_actual} unidades");
            $mensaje .= ' ⚠️ El stock quedó por debajo del mínimo.';
        }

        return redirect()->route('productos.index')->with('exito', $mensaje);
    }

    // Eliminar
    public function destroy(Producto $producto)
    {
        $nombre = $producto->nombre;
        $id = $producto->id_producto;
        $producto->delete();

        Movimiento::registrar('Producto', $id, 'producto_eliminado',
            "Se eliminó el producto \"{$nombre}\"");

        return redirect()->route('productos.index')->with('exito', 'Producto eliminado correctamente.');
    }
}