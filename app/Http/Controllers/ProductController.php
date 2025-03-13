<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required',
            'brand' => 'required',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|gt:purchase_price',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function getProductByCode($code)
    {
        $product = Product::where('code', $code)->first();
        return response()->json($product);
    }

    public function destroy(Product $product)
{
    // Eliminar los detalles de venta relacionados antes de eliminar el producto
    \DB::table('sale_details')->where('product_id', $product->id)->delete();

    // Ahora se puede eliminar el producto
    $product->delete();

    return redirect()->route('inventory.index')->with('success', 'Producto eliminado correctamente.');
}


}