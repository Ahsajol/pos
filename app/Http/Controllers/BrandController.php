<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    protected $brand;
    public function __construct()
    {
        $this->brand = new Brand();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response['brand'] = $this->brand->all();
        return view('brand.index')->with($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->brand->create($request->all());
        // return redirect('brand')->with('flash_message', 'Data Added Succesfully!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response['brand'] = $this->brand->find($id);
        return view('brand.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $brand = $this->brand->find($id);
        $brand->update(array_merge($brand->toArray(), $request->toArray()));
        return redirect('brand')->with('flash_message', 'Data Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $brand = $this->brand->find($id);
        $brand->delete();
        return redirect('brand')->with('flash_message', 'Data Deleted!');
    }
}
