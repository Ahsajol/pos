<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customers;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }
    public function index()
    {
        $products = Products::get();
        $customers = Customers::get();
        $sales = Sales::orderBy('id', 'desc')->paginate(100);
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->where('transaction_type', 'sales')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('sales.index', compact('products', 'customers', 'sales', 'cartItems'));
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'price' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'paid_amount' => 'required',
        ]);

        $sales = Sales::create($request->all());

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty -= $request->quantity;
        $inventory->stock_value -= $request->total_price;
        $inventory->save();

        // Update Customer due
        $customer = Customers::findOrFail($request->customer_id);
        $customer->customerpreviousdue += ($request->total_price - $request->paid_amount);
        $customer->save();

        return redirect()->route('sales.invoice', $sales->id)
            ->with('success', 'Product Sold successfully.');
    }

    public function show($id)
    {
        $sales = Sales::findOrFail($id);
        return response()->json($sales);
    }

    public function edit($id)
    {
        $products = Products::get();
        $customers = Customers::get();
        $sales = Sales::findOrFail($id);
        return view('sales.edit', compact('sales', 'products', 'customers', 'cartItems'));
    }

    public function update(Request $request, $id)
    {


        $sales = Sales::findOrFail($id);

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $request->product_id]);
        $inventory->stock_qty -= $sales->quantity;  // Subtract old quantity
        $inventory->stock_qty -= $request->quantity;  // minus sold quantity
        $inventory->save();

        // Update supplier due
        $customer = Customers::findOrFail($request->customer_id);
        $customer->customerpreviousdue -= ($sales->total_price - $sales->paid_amount); // Remove old due
        $customer->customerpreviousdue += ($request->total_price - $request->paid_amount); // Add new due
        $customer->save();

        $sales->update($request->all());

        return redirect('sales')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);

        // Update inventory
        $inventory = Inventory::firstOrNew(['product_id' => $sales->product_id]);
        $inventory->stock_qty -= $sales->quantity;
        $inventory->save();

        // Update supplier due
        $customer = Customers::findOrFail($sales->supplier_id);
        $customer->customerpreviousdue -= ($sales->total_price - $sales->paid_amount);
        $customer->save();

        $customer->delete();
        return redirect()->back()->with('alert', 'confirm')->with('error', 'Data Deleted');
    }

    public function invoice($id)
    {
        $sales = Sales::with('customers', 'product')->findOrFail($id);
        return view('sales.invoice', compact('sales'));
    }
    //     public function purchaseFromCart(Request $request)
    //     {
    //         $cartItems = Cart::where('user_id', Auth::id())->get();
    //         $customer_id = $request->customer_id;
    // 
    //         foreach ($cartItems as $item) {
    //             $sales = Sales::create([
    //                 'customer_id' => $item->customer_id,
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
    //             $inventory->stock_qty -= $item->quantity;
    //             $inventory->save();
    // 
    //             // Update supplier due
    //             $customer = Customers::findOrFail($item->customer_id);
    //             $customer->customerpreviousdue += ($sales->total_price - $sales->paid_amount);
    //             $customer->save();
    //         }
    // 
    //         // Clear the cart
    //         Cart::where('user_id', Auth::id())->delete();
    // 
    //         return redirect()->route('sales.invoice', $sales->id)
    //             ->with('success', 'Products Sold successfully.');
    //     }
    public function salesFromCart(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->where('transaction_type', 'sales')->get();
        $customer_id = $request->customer_id;

        foreach ($cartItems as $item) {
            $sales = Sales::create([
                'customer_id' => $item->customer_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total_price' => $item->quantity * $item->product->price,
                'paid_amount' => $item->paid_amount,
            ]);

            $inventory = Inventory::firstOrNew(['product_id' => $item->product_id]);
            $inventory->stock_qty -= $item->quantity;
            $inventory->save();

            $customer = Customers::findOrFail($item->customer_id);
            $customer->customerpreviousdue += ($sales->total_price - $sales->paid_amount);
            $customer->save();
        }

        Cart::where('user_id', Auth::id())->where('transaction_type', 'sales')->delete();

        return redirect()->route('sales.invoice', $sales->id)
            ->with('success', 'Products Sold successfully.');
    }
}
