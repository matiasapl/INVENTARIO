<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Registro;

class ProductController extends Controller
{

    // INICIO LISTAS DE PRODUCTOS
    /*
    * Mostrar productos activos del usuario autenticado.
    */
    public function index()
    {
        $products = Product::where('usuario', Auth::id())
            ->where('habilitado', true)
            ->where('eliminado', false)
            ->get();

        return inertia('Products/Index', compact('products'));
    }

    /*
    * Mostrar productos inactivos (papelera) del usuario autenticado.
    */


    public function papelera()
    {
        $products = Product::where('usuario', Auth::id())
            ->where('habilitado', false)
            ->where('eliminado', false)
            ->get();

        return inertia('Products/Papelera', compact('products'));
    }

        /**
     * Deshabilitar un producto
     */
    public function deshabilitar(Product $product)
    {
        $this->authorizeProduct($product);
        $product->deshabilitar();

    Registro::create([
        'codigo' => $product->codigo,
        'nombre' => $product->nombre,
        'accion' => 'Deshabilitar Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);

        return redirect()->route('products.index')->with('success', 'Producto deshabilitado correctamente');
    }
        /**
     * Habilitar un producto
     */
        public function habilitar(Product $product)
    {
        $this->authorizeProduct($product);
        $product->habilitar();

        Registro::create([
        'codigo' => $product->codigo,
        'nombre' => $product->nombre,
        'accion' => 'Habilitar Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
        ]);
        return redirect()->route('products.papelera')->with('success', 'Producto habilitado correctamente');
    }

            /**
     * Eliminar un producto
     */
    public function eliminar(Product $product)
    {
        $this->authorizeProduct($product);
        $product->eliminar();

    Registro::create([
        'codigo' => $product->codigo,
        'nombre' => $product->nombre,
        'accion' => 'Eliminar Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('products.papelera')->with('success', 'Producto eliminado correctamente');
    }

    
    /**
     * Formulario para crear productos.
     */
    public function create()
    {
        return inertia('Products/Create');
    }

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        Product::create($data);


    Registro::create([
        'codigo' => $request->codigo,
        'nombre' => $request->nombre,
        'accion' => 'Crear Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    /**
     * Formulario para editar productos.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        return inertia('Products/Edit', compact('product'));
    }

    /**
     * Ver producto creado por el usuario autenticado.
     */
    public function view(Product $product)
    {
        $this->authorizeProduct($product);
    Registro::create([
        'codigo' => $product->codigo,
        'nombre' => $product->nombre,
        'accion' => 'Ver Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);
        return inertia('Products/View', compact('product'));
    }

    /**
     * Actualizar producto creado por el usuario autenticado.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorizeProduct($product);

        $product->update($request->validated());


    Registro::create([
        'codigo' => $request->codigo,
        'nombre' => $request->nombre,
        'accion' => 'Editar Producto',
        'tipo' => 'manual',
        'usuario' => Auth::id()
    ]);
        return redirect()->route('products.index')->with('success', 'Producto editado correctamente');
    }

    /**
     * Verifica que el producto pertenece al usuario autenticado.
     */
    private function authorizeProduct(Product $product)
    {
        if ($product->usuario !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este producto.');
        }
    }
}

