<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
use App\Models\Product;
use App\Models\Almacen;
use App\Http\Requests\StoreLotesRequest;
use App\Http\Requests\UpdateLotesRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\InventoryAudit;

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
    public function deshabilitar(Lotes $Lote, InventoryAudit $audit)
    {
        $this->authorizeLotes($Lote);
        $audit->mutate('Deshabilitar Lote', $Lote, function (Lotes $Lote): Lotes {
            $Lote->deshabilitar();

            return $Lote;
        });

        return redirect()->route('lotes.index')->with('success', 'Lote deshabilitado correctamente');
    }
        /**
     * Habilitar un producto
     */
    public function habilitar(Lotes $Lote, InventoryAudit $audit)
    {
        $this->authorizeLotes($Lote);
        $audit->mutate('Habilitar Lote', $Lote, function (Lotes $Lote): Lotes {
            $Lote->habilitar();

            return $Lote;
        });
        return redirect()->route('lotes.papelera')->with('success', 'Lote habilitado correctamente');
    }

            /**
     * Eliminar un producto
     */
    public function eliminar(Lotes $Lote, InventoryAudit $audit)
    {
        $this->authorizeLotes($Lote);
        $audit->mutate('Eliminar Lotes', $Lote, function (Lotes $Lote): Lotes {
            $Lote->eliminar();

            return $Lote;
        });
        return redirect()->route('lotes.papelera')->with('success', 'Lotes eliminado correctamente');
    }

    
    /**
     * Formulario para crear productos.
     */
public function create()
{
    $products = Product::select('id', 'nombre', 'codigo')
        ->where('usuario', auth()->id())
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->get();

    $almacens = Almacen::select('id', 'nombre', 'codigo')
        ->where('usuario', auth()->id())
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->get();

    return inertia('Lotes/Create', [
        'products' => $products,
        'almacens' => $almacens
    ]);
}

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreLotesRequest $request, InventoryAudit $audit)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        $audit->mutate('Crear Lote', null, fn (): Lotes => Lotes::create($data));
        return redirect()->route('lotes.index')->with('success', 'Lote creado correctamente');
    }

    /**
     * Formulario para editar productos.
     */
public function edit(Lotes $Lote)
{
    $this->authorizeLotes($Lote);

    $products = Product::select('id', 'nombre', 'codigo')
        ->where('usuario', auth()->id())
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->get();

    $almacens = Almacen::select('id', 'nombre', 'codigo')
        ->where('usuario', auth()->id())
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->get();

    // IMPORTANTE: Añadir las variables al compact
    return inertia('Lotes/Edit', compact('Lote', 'products', 'almacens'));
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
    
        return inertia('Lotes/View', compact('VerLote'));
    }

    /**
     * Actualizar producto creado por el usuario autenticado.
     */
    public function update(UpdateLotesRequest $request, Lotes $Lote, InventoryAudit $audit)
    {
        $this->authorizeLotes($Lote);

        $data = $request->validated();
        $audit->mutate('Editar Lote', $Lote, function (Lotes $Lote) use ($data): Lotes {
            $Lote->update($data);

            return $Lote;
        });
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
