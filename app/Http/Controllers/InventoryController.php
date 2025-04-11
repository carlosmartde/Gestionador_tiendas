<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function search(Request $request)
{
    $query = $request->get('query');
    
    $products = Product::where('name', 'like', "%{$query}%")
                      ->orWhere('code', 'like', "%{$query}%")
                      ->paginate(10);
    
    if($request->ajax()) {
        return view('inventory.partials.products_table', compact('products'))->render();
    }
    
    return view('inventory.index', compact('products'));
}
    public function index()
    {
        $products = Product::paginate(10);
        return view('inventory.index', compact('products'));
    }

    private function checkRole($allowedRoles = ['admin'])
{
    $userRole = Auth::user()->rol ?? null;
    
    if (!$userRole || !in_array($userRole, $allowedRoles)) {
        if ($userRole === 'vendedor') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        
        return redirect()->route('login');
    }
    
    return null;
}
}