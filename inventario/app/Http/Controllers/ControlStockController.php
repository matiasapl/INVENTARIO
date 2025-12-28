<?php

namespace App\Http\Controllers;

use App\Models\control_stock;
use App\Http\Requests\Storecontrol_stockRequest;
use App\Http\Requests\Updatecontrol_stockRequest;
use Illuminate\Support\Facades\Auth;

class ControlStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Historial = control_stock::where('usuario', Auth::id())->get();

        return inertia('ControlStock/Index', compact('Historial'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('ControlStock/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecontrol_stockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(control_stock $control_stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(control_stock $control_stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatecontrol_stockRequest $request, control_stock $control_stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(control_stock $control_stock)
    {
        //
    }
}
