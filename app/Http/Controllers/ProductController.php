<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Brand;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $product;
    public function __construct()
    {
        $this->product = new Products();
    }

    public function index()
    {
        $products = $this->product->all();
        $category = Categories::pluck('catname', 'id');
        $brand = Brand::pluck('brandname', 'id');
        return view('product.index', compact('products', 'category', 'brand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->product->create($request->all());
        return redirect('product')->with('flash_message', 'Data Added Succesfully!');
        // return redirect()->back();
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
        // $response['product'] = $this->product->find($id);
        $product = Products::find($id);
        $categories = Categories::all();
        $brand = Brand::all();
        // return view('product.edit')->with($response);
        return view('product.edit', compact('product', 'categories', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $categories = Categories::find($id);
        // $brand = Brand::find($id);
        $products = Products::find($id);
        $input = $request->all();
        $products->update($input);
        return redirect('product')->with('flash_message', 'Data Updated!');
        //session()->flash('success', 'Product updated successfully!');
        //return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // $product = $this->product->find($id);
        // $product->delete();
        // return redirect('product')->with('flash_message', 'Data Deleted!');
        Products::destroy($id);
        return redirect('product')->with('flash_message', 'Data deleted!');
    }

    public function getFilteredProducts(Request $request)
    {
        $brandId = $request->query('brand_id');
        $categoryId = $request->query('cat_id');

        $products = Products::where('brand_id', $brandId)
            ->where('cat_id', $categoryId)
            ->get();

        return response()->json($products);
    }
}
