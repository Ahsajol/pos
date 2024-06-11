<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Suppliers::orderBy('id', 'desc')->get();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'suppliername' => 'required|unique:suppliers',
            'supplieraddress' => 'required',
            'supplierphone' => 'required|digits:11|unique:suppliers',
        ]);

        Suppliers::create($request->all());
        return redirect('supplier')->with(['success' => 'Data Added Successfully']);
    }

    public function show($id)
    {
        $suppliers = Suppliers::findOrFail($id);
        return response()->json($suppliers);
    }

    public function edit($id)
    {
        $suppliers = Suppliers::findOrFail($id);
        return view('supplier.edit', compact('suppliers')); // Create a separate 'edit' view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'suppliername' => [
                'required',
                Rule::unique('suppliers')->ignore($id),
            ],
            'supplierphone' => 'required|digits:11',
            'supplieraddress' => 'required',
        ]);

        $suppliers = Suppliers::findOrFail($id);
        $suppliers->update($request->all());
        return redirect('supplier')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $suppliers = Suppliers::findOrFail($id);
        $suppliers->delete();
        return redirect()->back()->with('alert', 'confirm')->with('error', 'Data Deleted');
    }
    public function dueReport(Request $request)
    {
        $query = Suppliers::query();

        if ($request->has('suppliername')) {
            $query->where('suppliername', 'like', '%' . $request->input('suppliername') . '%');
        }

        if ($request->has('supplierphone')) {
            $query->where('supplierphone', 'like', '%' . $request->input('supplierphone') . '%');
        }

        if ($request->has('date')) {
            $date = $request->input('created_at');
            $query->whereDate('created_at', $date);
        }
        $suppliers = $query->get();
        return view('supplier.duereport', compact('suppliers'));
    }
}
