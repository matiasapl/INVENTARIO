<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\InventoryAudit;

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
    public function store(StoreAlmacenRequest $request, InventoryAudit $audit)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        $audit->mutate('Crear Almacen', null, fn (): Almacen => Almacen::create($data));
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

    public function deshabilitar(Almacen $almacen, InventoryAudit $audit)
    {
        $this->authorizeAlmacen($almacen);

        if ($almacen->lotes()->exists()) {
            return redirect()->route('almacenes.index')->with('error', 'No se puede deshabilitar un almacén asociado a lotes.');
        }

        $audit->mutate('Deshabilitar Almacen', $almacen, function (Almacen $almacen): Almacen {
            $almacen->deshabilitar();

            return $almacen;
        });

        return redirect()->route('almacenes.index')->with('success', 'Almacen deshabilitado correctamente');
    }


    public function view(Almacen $Almacen)
    {
        $this->authorizeAlmacen($Almacen);
        return inertia('Almacenes/View', compact('Almacen'));
    }

    /**
     * Formulario para editar almacenes.
     */
    public function edit(Almacen $Almacen)
    {
        $this->authorizeAlmacen($Almacen);

        return inertia('Almacenes/Edit', compact('Almacen'));
    }

    public function update(UpdateAlmacenRequest $request, Almacen $almacen, InventoryAudit $audit)
    {
    $this->authorizeAlmacen($almacen);
        $data = $request->validated();
        $audit->mutate('Editar Almacen', $almacen, function (Almacen $almacen) use ($data): Almacen {
            $almacen->update($data);

            return $almacen;
        });


        return redirect()->route('almacenes.index')->with('success', 'Almacen Editado Correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Almacen $almacen)
    {
        //
    }


    public function habilitar(Almacen $almacen, InventoryAudit $audit)
    {
        $this->authorizeAlmacen($almacen);
        $audit->mutate('Habilitar Almacen', $almacen, function (Almacen $almacen): Almacen {
            $almacen->habilitar();

            return $almacen;
        });
        return redirect()->route('almacen.papelera')->with('success', 'Producto habilitado correctamente');
    }



    public function eliminar(Almacen $almacen, InventoryAudit $audit)
    {
        $this->authorizeAlmacen($almacen);

        if ($almacen->lotes()->exists()) {
            return redirect()->route('almacenes.index')->with('error', 'No se puede eliminar un almacén asociado a lotes.');
        }

        $audit->mutate('Eliminar Almacen', $almacen, function (Almacen $almacen): Almacen {
            $almacen->eliminar();

            return $almacen;
        });
        return redirect()->route('almacen.papelera')->with('success', 'Almacen Eliminado Correctamente');
    }




    /**
    * Verifica que el producto pertenece al usuario autenticado.
    */
    private function authorizeAlmacen(Almacen $almacen)
    {
        if ($almacen->usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este almacen.');
        }
    }
}
