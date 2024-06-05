<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customers::orderBy('id', 'desc')->get();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customername' => 'required|unique:customers',
            'customeraddress' => 'required',
            'customercreditlimit' => 'required|numeric|max:50000',
            'customerphone' => 'required|digits:11|unique:customers',
        ]);

        Customers::create($request->all());
        return redirect('customer')->with(['success' => 'Data Added Successfully']);
    }

    public function show($id)
    {
        $customers = Customers::findOrFail($id);
        return response()->json($customers);
    }

    public function edit($id)
    {
        $customers = Customers::findOrFail($id);
        return view('customer.edit', compact('customers')); // Create a separate 'edit' view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customername' => [
                'required',
                Rule::unique('customers')->ignore($id),
            ],
            'customerphone' => 'required|digits:11',
            'customeraddress' => 'required',
            'customercreditlimit' => 'required|numeric|max:100000',
        ]);

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
