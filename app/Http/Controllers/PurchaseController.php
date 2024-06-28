<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index()
    {
        $products = Products::get();
        $suppliers = Suppliers::get();
        $purchases = Purchases::orderBy('id', 'desc')->paginate(100);
        $cartItems = Cart::with('product')
        ->where('user_id', Auth::id())
        ->where('transaction_type', 'purchase')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('purchase.index', compact('products', 'suppliers', 'purchases', 'cartItems'));
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
            'paid_amount' => 'required',
        ]);

        $purchase = Purchases::create($request->all());

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty += $request->quantity;
        $inventory->stock_value += $request->total_price;
        $inventory->save();

        // Update supplier due
        $supplier = Suppliers::findOrFail($request->supplier_id);
        $supplier->supplierpreviousdue += ($request->total_price - $request->paid_amount);
        $supplier->save();

        return redirect()->route('purchase.invoice', $purchase->id)
            ->with('success', 'Product purchased successfully.');
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
       

        $purchase = Purchases::findOrFail($id);

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty -= $purchase->quantity;  // Subtract old quantity
        $inventory->stock_qty += $request->quantity;  // Add new quantity
        $inventory->save();

        // Update supplier due
        $supplier = Suppliers::findOrFail($request->supplier_id);
        $supplier->supplierpreviousdue -= ($purchase->total_price - $purchase->paid_amount); // Remove old due
        $supplier->supplierpreviousdue += ($request->total_price - $request->paid_amount); // Add new due
        $supplier->save();

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

        // Update supplier due
        $supplier = Suppliers::findOrFail($purchase->supplier_id);
        $supplier->supplierpreviousdue -= ($purchase->total_price - $purchase->paid_amount);
        $supplier->save();

        $purchase->delete();
        return redirect()->back()->with('alert', 'confirm')->with('error', 'Data Deleted');
    }

    public function invoice($id)
    {
        $purchase = Purchases::with('supplier', 'product')->findOrFail($id);
        return view('purchase.invoice', compact('purchase'));
    }
    //     public function purchaseFromCart(Request $request)
    //     {
    //         $cartItems = Cart::where('user_id', Auth::id())->where('transaction_type', 'purchase')->get();
    //         $supplier_id = $request->supplier_id;
    //         $purchase = [];
    // 
    //         foreach ($cartItems as $item) {
    //             // var_dump($item->supplier_id);
    //             // exit;
    //             // Create a new purchase entry
    //             $purchase = Purchases::create([
    //                 'supplier_id' => $item->supplier_id,
    //                 'product_id' => $item->product_id,
    //                 'quantity' => $item->quantity,
    //                 'price' => $item->product->price,
    //                 'total_price' => $item->quantity * $item->product->price,
    //                 // 'paid_amount' => $item->quantity * $item->product->price,
    //                 'paid_amount' => $item->paid_amount,
    //             ]);
    // 
    //             // Update inventory
    //             $inventory = Inventory::firstOrNew(['product_id' => $item->product_id]);
    //             $inventory->stock_qty += $item->quantity;
    //             $inventory->save();
    // 
    //             // Update supplier due
    //             $supplier = Suppliers::findOrFail($item->supplier_id);
    //             $supplier->supplierpreviousdue += ($purchase->total_price - $purchase->paid_amount);
    //             $supplier->save();
    //         }
    // 
    //         // Clear the cart
    //         Cart::where('user_id', Auth::id())->where('transaction_type', 'purchase')->delete();
    // 
    //         return redirect()->route('purchase.invoice', $purchase->id)
    //             ->with('success', 'Products purchased successfully.');
    //     }
    public function purchaseFromCart(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->where('transaction_type', 'purchase')->get();

        $purchases = [];

        foreach ($cartItems as $item) {
            // Create a new purchase entry
            $purchase = Purchases::create([
                'supplier_id' => $item->supplier_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total_price' => $item->quantity * $item->product->price,
                'paid_amount' => $item->paid_amount,
            ]);

            // Update inventory
            $inventory = Inventory::firstOrNew(['product_id' => $item->product_id]);
            $inventory->stock_qty += $item->quantity;
            $inventory->save();

            // Update supplier due
            $supplier = Suppliers::findOrFail($item->supplier_id);
            $supplier->supplierpreviousdue += ($purchase->total_price - $purchase->paid_amount);
            $supplier->save();

            // Add purchase to the list
            $purchases[] = $purchase;
        }

        // Clear the cart
        Cart::where('user_id', Auth::id())->where('transaction_type', 'purchase')->delete();

        // If you want to redirect to the invoice of the last purchase made
        if (!empty($purchases)) {
            return redirect()->route('purchase.invoice', end($purchases)->id)
                ->with('success', 'Products purchased successfully.');
        } else {
            return redirect()->route('purchase.index')
            ->with('success', 'No items in the cart.');
        }
    }
}
