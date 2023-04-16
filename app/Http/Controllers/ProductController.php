<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('some-view');
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
    public function store(StoreProductRequest $request)
    {
        $validation = $request->validated();
        if (!$validation) {
          return redirect()->back()->withErrors($validation);
        }
        Product::create($validation);
        return redirect('some-view')->with('create_success', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('some-view', compact($product));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('some-view', compact($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $validation = $request->validated();
        if (!$validation) {
          return redirect()->back()->withErrors($validation);
        }
        Product::update($validation);
        return redirect('some-view')->with('update_success', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productId)
    {
        $isDelete = Product::whereId($productId)->delete();
        return redirect('some-view')->with('delete_success', 'Product Deleted Successfully');
    }
}
