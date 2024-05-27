<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;



class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $category;
    public function __construct()
    {
        $this->category = new Categories();
    }


    public function index()
    {
        $response['categories'] = $this->category->all();
        return view('category.index')->with($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->category->create($request->all());
        // return redirect('category')->with('flash_message', 'Data Added Succesfully!');
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
        $response['category'] = $this->category->find($id);
        return view('category.edit')->with($response);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $category = $this->category->find($id);
        $category->update(array_merge($category->toArray(), $request->toArray()));
        return redirect('category')->with('flash_message', 'Data Updated!');
    }


    /**
     * Remove the specified resource from storage.
     * : RedirectResponse
     */
    public function destroy(string $id)
    {
        $category = $this->category->find($id);
        $category->delete();
        return redirect('category')->with('flash_message', 'Data Deleted!');
    }
}
