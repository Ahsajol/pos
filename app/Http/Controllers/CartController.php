<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'customer_id' => 'required_if:transaction_type,sales|exists:customers,id',
            'supplier_id' => 'required_if:transaction_type,purchase|exists:suppliers,id',
            'paid_amount' => 'required|numeric|min:0',
            'transaction_type' => 'required|in:purchase,sales'
        ]);

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'transaction_type' => $request->transaction_type,
                'customer_id' => $request->transaction_type == 'sales' ? $request->customer_id : null,
                'supplier_id' => $request->transaction_type == 'purchase' ? $request->supplier_id : null
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity),
                'paid_amount' => $request->paid_amount
            ]
        );

        return redirect()->route($request->transaction_type . '.index')->with('success', 'Product added to cart');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        if ($cartItem->user_id == Auth::id()) {
            $cartItem->delete();
        }
        return redirect()->back()->with('success', 'Product removed from cart');
    }
}
