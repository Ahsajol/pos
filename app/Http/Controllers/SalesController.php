<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $products = Products::with(['brand', 'category'])->get();
        $customers = Customers::all();
        return view('sale.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        $customers = Customers::findOrFail($request->customer_id);
        $quantity = $request->quantity;
        $total_price = $product->price * $quantity;

        $sale = new Sales();
        $sale->product_id = $product->id;
        $sale->customer_id = $customers->id;
        $sale->quantity = $quantity;
        $sale->total_price = $total_price;
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }
}
