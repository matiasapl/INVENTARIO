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
    $Lotes = Lotes::join('products', 'lotes.producto_id', '=', 'products.id')
        ->join('almacens', 'lotes.almacen_id', '=', 'almacens.id')
        ->where('lotes.usuario', auth()->id())
        ->where('lotes.habilitado', true)
        ->where('lotes.eliminado', false)
        ->select(
            'lotes.id as id',
            'lotes.codigo as codigo',
            'lotes.descripcion as descripcion',
            'products.nombre as producto', // Alias para evitar colisiones
            'lotes.cantidad as cantidad',
            'almacens.nombre as almacen',
            'lotes.estado as estado'
        )
        ->paginate(25);

    return inertia('Lotes/Index', [
        'Lotes' => $Lotes
    ]);
}


    public function papelera()
    {
    $Lotes = Lotes::join('products', 'lotes.producto_id', '=', 'products.id')
        ->join('almacens', 'lotes.almacen_id', '=', 'almacens.id')
        ->where('lotes.usuario', auth()->id())
        ->where('lotes.habilitado', false)
        ->where('lotes.eliminado', false)
        ->select(
            'lotes.id as id',
            'lotes.codigo as codigo',
            'lotes.descripcion as descripcion',
            'products.nombre as producto',
            'lotes.cantidad as cantidad',
            'almacens.nombre as almacen',
            'lotes.estado as estado'
        )
        ->paginate(25);

        return inertia('Lotes/Papelera', compact('Lotes'));
    }

        /**
     * Deshabilitar un Lote
     */
    public function deshabilitar(Lotes $Lote)
    {
        $this->authorizeLotes($Lote);
        $Lote->deshabilitar();

    Registro::create([
        'codigo' => $Lote->codigo,
        'nombre' => $Lote->descripcion,
        'accion' => 'Deshabilitar Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);

        return redirect()->route('lotes.index')->with('success', 'Lote deshabilitado correctamente');
    }
        /**
     * Habilitar un producto
     */
    public function habilitar(Lotes $Lote)
    {
        $this->authorizeLotes($Lote);
        $Lote->habilitar();

        Registro::create([
        'codigo' => $Lote->codigo,
        'nombre' => $Lote->descripcion,
        'accion' => 'Habilitar Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
        ]);
        return redirect()->route('lotes.papelera')->with('success', 'Lote habilitado correctamente');
    }

            /**
     * Eliminar un producto
     */
    public function eliminar(Lotes $Lote)
    {
        $this->authorizeLotes($Lote);
        $Lote->eliminar();

    Registro::create([
        'codigo' => $Lote->codigo,
        'nombre' => $Lote->descripcion,
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
        'nombre' => $Lotes->descripcion,
        'accion' => 'Crear Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('lotes.index')->with('success', 'Lote creado correctamente');
    }

    /**
     * Formulario para editar productos.
     */
    public function edit(Lotes $Lote)
    {
        $this->authorizeLotes($Lote);

        return inertia('Lotes/Edit', compact('Lote'));
    }

    /**
     * Ver producto creado por el usuario autenticado.
     */
    public function view(Lotes $Lote)
    {
    $this->authorizeLotes($Lote);
    
    $VerLote = Lotes::join('products', 'lotes.producto_id', '=', 'products.id')
            ->join('almacens', 'lotes.almacen_id', '=', 'almacens.id')
            ->where('lotes.id', '=', $Lote->id)
            ->where('lotes.usuario', auth()->id())
            ->where('lotes.habilitado', true)
            ->where('lotes.eliminado', false)
            ->select(
                'lotes.codigo as codigo',
                'lotes.descripcion as descripcion',
                'products.nombre as producto',
                'lotes.cantidad as cantidad',
                'almacens.nombre as almacen',
                'lotes.estado as estado'
            )->first();

            if (!$VerLote) {
                return redirect()->route('lotes.index')->with('error', 'No se encontró el lote o no tienes permisos.');
            }
    
    Registro::create([
        'codigo' => $Lote->codigo,
        'nombre' => $Lote->descripcion,
        'accion' => 'Ver Lote',
        'tipo' => 'Manual',
        'usuario' => Auth::id()
    ]);
        return inertia('Lotes/View', compact('VerLote'));
    }

    /**
     * Actualizar producto creado por el usuario autenticado.
     */
    public function update(UpdateLotesRequest $request, Lotes $Lote)
    {
        $this->authorizeLotes($Lote);

        $Lote->update($request->validated());


    Registro::create([
        'codigo' => $Lote->codigo,
        'nombre' => $request->descripcion,
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
        if ($Lotes->usuario != Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este Lote.');
        }
    }
}
