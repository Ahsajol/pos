<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $products = Products::get();
        $suppliers = Suppliers::get();
        $purchases = Purchases::orderBy('id', 'desc')->get();
        return view('purchase.index', compact('purchases', 'suppliers', 'products'));
    }

    public function create()
    {
        return view('purchase.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $purchase = Purchases::create($request->all());

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty += $request->quantity;
        $inventory->save();

        return redirect('purchase')->with(['success' => 'Data Added Successfully']);
    }

    public function show($id)
    {
        $purchases = Purchases::findOrFail($id);
        return response()->json($purchases);
    }

    public function edit($id)
    {
        $products = Products::get();
        $suppliers = Suppliers::get();
        $purchases = Purchases::findOrFail($id);
        return view('purchase.edit', compact('purchases', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
        ]);

        $purchase = Purchases::findOrFail($id);

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty -= $purchase->quantity;  // Subtract old quantity
        $inventory->stock_qty += $request->quantity;  // Add new quantity
        $inventory->save();

        $purchase->update($request->all());

        return redirect('purchase')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $purchase = Purchases::findOrFail($id);

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $purchase->product_id]);
        $inventory->stock_qty -= $purchase->quantity;
        $inventory->save();

        $purchase->delete();
        return redirect()->back()->with('alert', 'confirm')->with('error', 'Data Deleted');
    }
}
