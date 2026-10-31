<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\InventoryAudit;

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
            ->paginate(25);

        return inertia('Productos/Index', [
            'products' => $products
        ]);
    }


    public function Dashboard()
    {


    $products = Product::where('usuario', Auth::id())
        ->where('habilitado', true)
        ->where('eliminado', false)
        ->select('nombre', 'descripcion', 'precio_unitario', 'M3_unitario', 'created_at as creacion', 'updated_at as ultima_actualizacion')
        ->paginate(25);

    $products->getCollection()->transform(function ($product) {
        $product->valor_total = $product->precio_unitario * 1;
        $product->m3_total = $product->M3_unitario * 1;
        return $product;
    });


        return inertia('dashboard', [
            'products' => $products
        ]);
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

        return inertia('Productos/Papelera', compact('products'));
    }

        /**
     * Deshabilitar un producto
     */
    public function deshabilitar(Product $product, InventoryAudit $audit)
    {
        $this->authorizeProduct($product);

        if ($product->lotes()->exists()) {
            return redirect()->route('products.index')->with('error', 'No se puede deshabilitar un producto asociado a lotes.');
        }

        $audit->mutate('Deshabilitar Producto', $product, function (Product $product): Product {
            $product->deshabilitar();

            return $product;
        });

        return redirect()->route('products.index')->with('success', 'Producto deshabilitado correctamente');
    }
        /**
     * Habilitar un producto
     */
    public function habilitar(Product $product, InventoryAudit $audit)
    {
        $this->authorizeProduct($product);
        $audit->mutate('Habilitar Producto', $product, function (Product $product): Product {
            $product->habilitar();

            return $product;
        });
        return redirect()->route('products.papelera')->with('success', 'Producto habilitado correctamente');
    }

            /**
     * Eliminar un producto
     */
    public function eliminar(Product $product, InventoryAudit $audit)
    {
        $this->authorizeProduct($product);

        if ($product->lotes()->exists()) {
            return redirect()->route('products.index')->with('error', 'No se puede eliminar un producto asociado a lotes.');
        }

        $audit->mutate('Eliminar Producto', $product, function (Product $product): Product {
            $product->eliminar();

            return $product;
        });
        return redirect()->route('products.papelera')->with('success', 'Producto eliminado correctamente');
    }

    
    /**
     * Formulario para crear productos.
     */
    public function create()
    {
        return inertia('Productos/Create');
    }

    /**
     * Guardar un nuevo producto asociado al usuario autenticado.
     */
    public function store(StoreProductRequest $request, InventoryAudit $audit)
    {
        $data = $request->validated();
        $data['usuario'] = Auth::id();

        $audit->mutate('Crear Producto', null, fn (): Product => Product::create($data));
        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    /**
     * Formulario para editar productos.
     */
    public function edit(Product $product)
    {
        $this->authorizeProduct($product);

        return inertia('Productos/Edit', compact('product'));
    }

    /**
     * Ver producto creado por el usuario autenticado.
     */
    public function view(Product $product)
    {
        $this->authorizeProduct($product);
        return inertia('Productos/View', compact('product'));
    }

    /**
     * Actualizar producto creado por el usuario autenticado.
     */
    public function update(UpdateProductRequest $request, Product $product, InventoryAudit $audit)
    {
        $this->authorizeProduct($product);

        $data = $request->validated();
        $audit->mutate('Editar Producto', $product, function (Product $product) use ($data): Product {
            $product->update($data);

            return $product;
        });
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
