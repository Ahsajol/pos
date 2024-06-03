<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customers::all();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create'); // Create a separate 'create' view or use the same 'index' view.
    }

    public function store(Request $request)
    {
        Customers::create($request->all());
        return redirect('customer')->with(['success' => 'Data Added Successfully']);
    }

    public function edit($id)
    {
        $customers = Customers::findOrFail($id);
        return view('customer.edit', compact('customers')); // Create a separate 'edit' view
    }

    public function update(Request $request, $id)
    {
        $customers = Customers::findOrFail($id);
        $customers->update($request->all());
        return redirect('customer')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $customers = Customers::findOrFail($id);
        $customers->delete();
        return redirect()->back()->with('alert', 'confirm')->with('error', 'Data Deleted');
    }
}
