<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Http\Requests\StoreAlmacenRequest;
use App\Http\Requests\UpdateAlmacenRequest;
use Illuminate\Support\Facades\Auth;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlmacenRequest $request)
    {
        //
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
}
