<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;

class AlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Almacenes = Almacen::where('usuario', Auth::id())
            ->where('habilitado', true)
            ->where('eliminado', false)
            ->paginate(25);

        return inertia('Almacenes/Index', [
            'Almacenes' => $Almacenes
        ]);
    }

    /**
     * Formulario para crear productos.
     */
    public function create()
    {
        return inertia('Almacenes/Create');
    }

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreAlmacenRequest $request)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        $almacen = Almacen::create($data);
        $almacen->refresh();
    
        Registro::create([
        'codigo' => $almacen->codigo,
        'nombre' => $almacen->nombre,
        'accion' => 'Crear Almacen',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('almacenes.index')->with('success', 'Almacen creado correctamente');
    }


    public function papelera()
    {
        $Almacenes = Almacen::where('usuario', Auth::id())
            ->where('habilitado', false)
            ->where('eliminado', false)
            ->get();

        return inertia('Almacenes/Papelera', compact('Almacenes'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Almacen $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Almacen $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlmacenRequest $request, Almacen $almacen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        //
    }


    public function habilitar(Almacen $almacen)
    {
        $this->authorizeAlmacen($almacen);
        $almacen->habilitar();

        Registro::create([
        'codigo' => $almacen->codigo,
        'nombre' => $almacen->nombre,
        'accion' => 'Habilitar Almacen',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
        ]);
        return redirect()->route('almacen.papelera')->with('success', 'Producto habilitado correctamente');
    }



    public function eliminar(Almacen $almacen)
    {
        $this->authorizeAlmacen($almacen);
        $almacen->eliminar();

        
    Registro::create([
        'codigo' => $almacen->codigo,
        'nombre' => $almacen->nombre,
        'accion' => 'Eliminar Almacen',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('almacen.papelera')->with('success', 'Almacen Eliminado Correctamente');
    }




    /**
    * Verifica que el producto pertenece al usuario autenticado.
    */
    private function authorizeAlmacen(Almacen $almacen)
    {
        if ($almacen->usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a almacen.');
        }
    }
}
