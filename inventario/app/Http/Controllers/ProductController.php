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
                       ->where('eliminado', false)
                       ->get();

    return inertia('Products/Index', [
        'products' => $products
    ]);
}

public function Papelera()
{
    $products = Product::where('usuario', Auth::id())
                       ->where('habilitado', false)
                       ->where('eliminado', false)
                       ->get();

    return inertia('Products/Papelera', [
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

    public function edit(Product $product){
        return inertia('Products/Edit', [
            'product' => $product]);
    }

        public function View(Product $product){
        return inertia('Products/View', [
            'product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product){
        $validated = $request->validated();

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto Editado correctamente');
    }
}
