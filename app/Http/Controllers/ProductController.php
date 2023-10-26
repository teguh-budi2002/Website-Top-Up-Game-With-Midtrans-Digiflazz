<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Models\Item;
use App\Models\PaymentFee;
use App\Models\PaymentGatewayProvider;
use App\Models\ProductPaymentMethod;
use App\Models\Provider;

class ProductController extends Controller
{
    public function index() {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function addImgItemOnProduct($product_id)
    {
        $product = Product::select("id", "product_name")->whereId($product_id )->first();
        return view("dashboard.views.manage_product.add_item_image_on_product", ["product" => $product]);
    }

    public function addImgItemOnProductProcess(Request $request, $product_id)
    {
        $img_item = $request->file("item_img");
        $filename = $img_item->getClientOriginalName();

        $dataOldImg = Product::select("id", "item_img")->whereId($product_id)->first();
        $deleteOldImage = self::deleteOldImage($dataOldImg, public_path("storage/item/" . $request->product_name . "/" . $dataOldImg->item_img));
        if ($img_item) {
            $putImgIntoStorage = Storage::putFileAs('/public/item/' . $request->product_name . "/", $img_item, $filename);
        }
        $updateProduct = Product::whereId($product_id)->update(["item_img"=> $filename]);
        return redirect("dashboard/products")->with("update_success","Added Image For Item Product Successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validation = $request->validated();
        $img_product = $request->file('img_url');
        $filename = $img_product->getClientOriginalName();

        if (!$validation) {
            return redirect()->back()->withErrors($validation);
        }

        if ($img_product) {            
            $putImgIntoStorage = Storage::putFileAs('/public/product/' . $request->product_name . "/", $img_product, $filename);
        }


        $validation['slug'] = Str::slug($request->product_name);
        Product::create([
            'product_name' => $request->get('product_name'),
            'category_id'  => $request->category_id,
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
        Product::whereId($id)->update($validation);
        return redirect('some-view')->with('update_success', 'Product Updated Successfully');
    }

    public function changeImageProduct($product_id) 
    {
        $product = Product::select("id", "product_name", "img_url")->whereId($product_id )->first();
        return view("dashboard.views.manage_product.change_image_on_product", ["product" => $product]);
    }

    public function changeImageProductProcess(Request $request, $product_id) 
    {
        $file = $request->file("img_url");
        $filename = $file->getClientOriginalName();
        $path = "/public/product/" . $request->product_name . '/';

        $dataOldImg = Product::select("id", "img_url")->whereId($product_id)->first();
        $deleteOldImage = self::deleteOldImage($dataOldImg, public_path("storage/product/" . $request->product_name . "/" . $dataOldImg->img_url));

         if ($file) {            
            $putImgIntoStorage = Storage::putFileAs($path, $file, $filename);
        }
        
        $updateProduct = Product::whereId($product_id)->update([
            "img_url" => $filename,
            "is_testing" => 0
        ]);
        return redirect("dashboard/products")->with("update_success","Added Image For Item Product Successfully");
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

    public function publishProduct($product_id) {
        if (PaymentGatewayProvider::where('status', 1)->count() === 0) {
            return redirect()->back()->with('product-failed', 'Please set up and activated a payment gateway provider before publishing the product');
        }

        if (Provider::where('status', 1)->count() === 0) {
            return redirect()->back()->with('product-failed', 'Please set up and activated a marketplace provider before publishing the product');
        }

        if (ProductPaymentMethod::whereProductId($product_id)->count() === 0) {
            return redirect()->back()->with('product-failed', 'Please set up payment support for the product before the product is published');
        }

        if (PaymentFee::count() === 0) {
            return redirect()->back()->with('product-failed', 'Please set the payment fee for the support payment method before publishing the product.');
        }

        if (Item::whereProductId($product_id)->count() === 0) {
            return redirect()->back()->with('product-failed', 'Please create at least 1 item for the product before the product is published.');
        }

        Product::whereId($product_id)->update([
            'published' => 1
        ]);

        return redirect()->back()->with('update_success', 'Product Has Been Published');
    }

    public function unpublishProduct($product_id) {
        $productUnpublished = Product::whereId($product_id)->update([
            'published' => 0
        ]);
        $product = Product::select("product_name")->whereId($product_id)->first();

        return redirect()->back()->with('product-failed', 'Product ' . ucwords($product->product_name) . ' Successfully Unpublished');
    }

}
