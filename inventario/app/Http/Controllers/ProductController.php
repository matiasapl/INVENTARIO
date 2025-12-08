<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Mostrar todos los productos del usuario autenticado.
     */

public function index()
{
    $products = Product::where('usuario', Auth::id())
                       ->where('habilitado', true)
                       ->get();

    return inertia('Products/Index', [
        'products' => $products
    ]);
}
        public function create(){
            return inertia('Products/Create', [
                'products' => new Product()
            ]);    
        }

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id(); // Asigna el usuario autenticado

        $product = Product::create($data);

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }
}
