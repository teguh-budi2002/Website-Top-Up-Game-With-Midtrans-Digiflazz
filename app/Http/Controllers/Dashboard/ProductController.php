<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        return redirect()->back()->with('create_success', 'Product Created Successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
    public function destroy(string $productId)
    {
        $isDelete = Product::whereId($productId)->delete();
        return redirect()->back()->with('delete_success', 'Product Deleted Successfully');
    }

    /**
     * Remove the choice resource from storage.
     */
    public function deleteManyResource(Request $request) {
      $selectedProductRecords =  $request->productIds;
      $isDelete = Product::whereIn('id', $selectedProductRecords)->delete();
      return response()->json(['message' => 'Product Deleted Successfully'], 200);
    }

}
