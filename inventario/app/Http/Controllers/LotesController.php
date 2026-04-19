<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
use App\Http\Requests\StoreLotesRequest;
use App\Http\Requests\UpdateLotesRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;

class LotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Lotes = Lotes::where('usuario', Auth::id())
            ->where('habilitado', true)
            ->where('eliminado', false)
            ->paginate(25);

        return inertia('Lotes/Index', [
            'Lotes' => $Lotes
        ]);
    }


    public function papelera()
    {
        $Lotes = Lotes::where('usuario', Auth::id())
            ->where('habilitado', false)
            ->where('eliminado', false)
            ->get();

        return inertia('Lotes/Papelera', compact('Lotes'));
    }

        /**
     * Deshabilitar un Lote
     */
    public function deshabilitar(Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);
        $Lotes->deshabilitar();

    Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $Lotes->nombre,
        'accion' => 'Deshabilitar Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);

        return redirect()->route('lotes.index')->with('success', 'Lote deshabilitado correctamente');
    }
        /**
     * Habilitar un producto
     */
    public function habilitar(Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);
        $Lotes->habilitar();

        Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $Lotes->nombre,
        'accion' => 'Habilitar Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
        ]);
        return redirect()->route('lotes.papelera')->with('success', 'Lote habilitado correctamente');
    }

            /**
     * Eliminar un producto
     */
    public function eliminar(Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);
        $Lotes->eliminar();

    Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $Lotes->nombre,
        'accion' => 'Eliminar Lotes',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('lotes.papelera')->with('success', 'Lotes eliminado correctamente');
    }

    
    /**
     * Formulario para crear productos.
     */
    public function create()
    {
        return inertia('Lotes/Create');
    }

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreLotesRequest $request)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        $Lotes = Lotes::create($data);
        $Lotes->refresh();
        
    Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $Lotes->nombre,
        'accion' => 'Crear Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('lotes.index')->with('success', 'Lote creado correctamente');
    }

    /**
     * Formulario para editar productos.
     */
    public function edit(Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);

        return inertia('Lotes/Edit', compact('Lotes'));
    }

    /**
     * Ver producto creado por el usuario autenticado.
     */
    public function view(Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);
    Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $Lotes->nombre,
        'accion' => 'Ver Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return inertia('Lotes/View', compact('Lotes'));
    }

    /**
     * Actualizar producto creado por el usuario autenticado.
     */
    public function update(UpdateLoteRequest $request, Lotes $Lotes)
    {
        $this->authorizeLotes($Lotes);

        $Lotes->update($request->validated());


    Registro::create([
        'codigo' => $Lotes->codigo,
        'nombre' => $request->nombre,
        'accion' => 'Editar Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('lotes.index')->with('success', 'Lote editado correctamente');
    }

    /**
     * Verifica que el Lote pertenece al usuario autenticado.
     */
    private function authorizeLotes(Lotes $Lotes)
    {
        if ($Lotes->usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este Lote.');
        }
    }
}
