<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Search logic
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('suppliername', 'like', '%' . $search . '%')
                    ->orWhere('supplierphone', 'like', '%' . $search . '%');
            });
        }

        // Filter logic
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            if ($filter == 'high') {
                $query->orderBy('supplierpreviousdue', 'desc');
            } elseif ($filter == 'low') {
                $query->orderBy('supplierpreviousdue', 'asc');
            }
        }

        // Get the results
        $suppliers = $query->get();

        return view('suppliers.index', compact('suppliers'));
    }
}
