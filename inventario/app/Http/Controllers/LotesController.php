<?php

namespace App\Http\Controllers;

use App\Models\Lotes;
use App\Http\Requests\StoreLotesRequest;
use App\Http\Requests\UpdateLotesRequest;
use Illuminate\Support\Facades\Auth;

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
    public function store(StoreLotesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lotes $lotes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lotes $lotes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLotesRequest $request, Lotes $lotes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lotes $lotes)
    {
        //
    }
}
