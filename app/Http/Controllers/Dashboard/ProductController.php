<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        $img_product = $request->file('img_url');
        $filename = $img_product->getClientOriginalName();
        $path = "product/" . $request->product_name . "/";

        if (!$validation) {
            return redirect()->back()->withErrors($validation);
        }

        if ($img_product) {            
            $putImgIntoStorage = Storage::putFileAs('/public/product/' . $request->product_name . "/", $img_product, $filename);
        }


        $validation['slug'] = Str::slug($request->product_name);
        Product::create([
            'product_name' => $request->get('product_name'),
            'slug' => Str::slug($request->get('product_name')),
            'img_url' => $filename
        ]);
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
     * Remove many resource from storage.
     */
    public function deleteManyResource(Request $request) {
      $selectedProductRecords =  $request->productIds;
      $isDelete = Product::whereIn('id', $selectedProductRecords)->delete();
      return response()->json(['message' => 'Product Deleted Successfully'], 200);
    }

}
