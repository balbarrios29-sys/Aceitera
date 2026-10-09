<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('buscar')) {
            $texto = $request->buscar;
            $query->where(function ($q) use ($texto) {
                $q->where('nombre', 'like', "%$texto%")
                  ->orWhere('codigo', 'like', "%$texto%")
                  ->orWhere('nit', 'like', "%$texto%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $clientes = $query->orderBy('nombre')->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => 'nullable|string|max:30|unique:cliente,codigo',
            'nombre' => 'required|string|max:100',
            'nit' => 'nullable|string|max:30',
            'tipo' => 'required|string|max:30',
            'telefono' => 'nullable|string|max:20',
            'vehiculo' => 'nullable|string|max:100',
            'ultima_visita' => 'nullable|date',
            'dias_credito' => 'nullable|integer|min:0',
            'saldo_pendiente' => 'nullable|numeric|min:0',
        ]);

        $cliente = Cliente::create($datos);

        Movimiento::registrar('Cliente', $cliente->id_cliente, 'cliente_creado',
            "Se registró el cliente \"{$cliente->nombre}\"");

        return redirect()->route('clientes.index')->with('exito', 'Cliente registrado correctamente.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $datos = $request->validate([
            'codigo' => 'nullable|string|max:30|unique:cliente,codigo,' . $cliente->id_cliente . ',id_cliente',
            'nombre' => 'required|string|max:100',
            'nit' => 'nullable|string|max:30',
            'tipo' => 'required|string|max:30',
            'telefono' => 'nullable|string|max:20',
            'vehiculo' => 'nullable|string|max:100',
            'ultima_visita' => 'nullable|date',
            'dias_credito' => 'nullable|integer|min:0',
            'saldo_pendiente' => 'nullable|numeric|min:0',
        ]);

        $cliente->update($datos);

        Movimiento::registrar('Cliente', $cliente->id_cliente, 'cliente_editado',
            "Se editó el cliente \"{$cliente->nombre}\"");

        return redirect()->route('clientes.index')->with('exito', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $nombre = $cliente->nombre;
        $id = $cliente->id_cliente;
        $cliente->delete();

        Movimiento::registrar('Cliente', $id, 'cliente_eliminado',
            "Se eliminó el cliente \"{$nombre}\"");

        return redirect()->route('clientes.index')->with('exito', 'Cliente eliminado correctamente.');
    }
}