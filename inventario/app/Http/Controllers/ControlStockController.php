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
    $Historial = \DB::table('control_stocks as stock')
        ->join('users', 'stock.usuario', '=', 'users.id')
        ->where('stock.usuario', Auth::id())
        ->select('stock.codigo', 'stock.nombre', 'stock.stock_previo', 'stock.stock_actual', 'stock.accion', 'stock.tipo','users.name as responsable')
        ->get();

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
        'codigo' => 'required|integer',
        'nombre' => 'required|string',
        'stock_previo' => 'required|integer|min:0',
        'cantidad' => 'required|integer|min:1'
    ]);

    $producto = Product::where('id', $id)
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->firstOrFail();

    $this->authorizeProduct($producto);
    $producto->sumar($request->cantidad);

    control_stock::create([
        'codigo' => $request->codigo,
        'nombre' => $request->nombre,
        'stock_previo' => $request->stock_previo,
        'stock_actual' => $request->stock_previo + $request->cantidad,
        'accion' => 'suma',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);

    return redirect()->route('controlstock.index')
        ->with('success', 'Stock aumentado correctamente.');
}




public function restar(Request $request, $id)
{
    $request->validate([
        'codigo' => 'required|integer',
        'nombre' => 'required|string',
        'stock_previo' => 'required|integer|min:0',
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

        control_stock::create([
        'codigo' => $request->codigo,
        'nombre' => $request->nombre,
        'stock_previo' => $request->stock_previo,
        'stock_actual' => $request->stock_previo - $request->cantidad,
        'accion' => 'resta',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);

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
