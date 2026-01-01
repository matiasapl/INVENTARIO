<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\control_stock;
use App\Http\Requests\Storecontrol_stockRequest;
use App\Http\Requests\Updatecontrol_stockRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $DropDown = Product::where('usuario', Auth::id())
            ->where('habilitado', true)
            ->where('eliminado', false)
            ->select('id', 'codigo', 'nombre', 'stock')
            ->get();
        return inertia('ControlStock/Create', compact('DropDown'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storecontrol_stockRequest $request)
    {

    }



public function sumar(Request $request, $id)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1'
    ]);

    // Buscar el producto y validar que esté habilitado y no eliminado
    $producto = Product::where('id', $id)
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->firstOrFail();

    $this->authorizeProduct($producto);

    $producto->sumar($request->cantidad);

    return redirect()->route('controlstock.index')
        ->with('success', 'Stock aumentado correctamente.');
}



public function restar(Request $request, $id)
{
    $request->validate([
        'cantidad' => 'required|integer|min:1'
    ]);

    $producto = Product::where('id', $id)
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->firstOrFail();

    $this->authorizeProduct($producto);

    if ($producto->stock < $request->cantidad) {
        return redirect()->route('controlstock.index')
            ->with('error', 'No hay suficiente stock para restar.');
    }

    $producto->restar($request->cantidad);

    return redirect()->route('controlstock.index')
        ->with('success', 'Stock restado correctamente.');
}



    private function authorizeProduct(Product $product)
    {
        if ($product->usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este producto.');
        }
    }
}
