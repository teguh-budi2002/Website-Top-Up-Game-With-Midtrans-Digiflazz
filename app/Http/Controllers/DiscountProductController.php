<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountProduct;
use Illuminate\Support\Facades\DB;

class DiscountProductController extends Controller
{
    public function addDiscountIntoItemProduct(Request $request) {
        $validation = $request->validate([
            'product_id'      => 'required',
            'item_id'         => 'required',
            'discount_fixed'  => 'required_without:discount_flat',
            'discount_flat'   => 'required_without:discount_fixed',
            'type_discount'   => 'required',
            'price_after_discount' => 'required'
        ], [
            'product_id.required'             => "Choose At Least 1 Product",
            'item_id.required'                => "Choose At Least 1 Item",
            'discount_fixed.required_without' => "Discount Fixed or Discount Flat must be filled",
            'discount_flat.required_without'  => "Discount Fixed or Discount Flat must be filled",
            'type_discount.required'          => "Choose One of Type Discount"
        ]);

        if (!empty($request->input('discount_fixed')) && !is_numeric($request->input('discount_fixed'))) {
            return redirect()->back()->with('error-discount', 'Discount Flat or Discount Fixed Must Be Filled a Number');
        } 
        
        if(!empty($request->input('discount_flat')) && !is_numeric($request->input('discount_flat'))) {
            return redirect()->back()->with('error-discount', 'Discount Flat or Discount Fixed Must Be Filled a Number');
        }

        // Check If Discount Has Been Created At The Same Item_ID
        $fetchDiscountByItemId = DiscountProduct::whereItemId($request->item_id)->count();
        if ($fetchDiscountByItemId > 0) {
            return redirect()->back()->with('error-discount', 'Selected Items Are Already Discounted, Please Select Another Item.');
        }

        DB::beginTransaction();
        try {
            $discountCreated = DiscountProduct::create($validation);
            DB::commit();
            return redirect('dashboard/discount')->with('success-add-discount', 'Successfully Added Discount On Product');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error-discount', 'SERVER ERROR: ' . $th->getMessage());
        }
    }

    public function activatedDiscount($item_id) {
        $filterByItemId = DiscountProduct::whereItemId($item_id)->first();
        $setFlashSale = $filterByItemId->update(['status_discount' => 1]);

        return redirect('dashboard/list-discount')->with('flashsale', 'Item Discount has been activated');
    }

    public function deactiveDiscount($item_id) {
        $filterByItemId = DiscountProduct::whereItemId($item_id)->first();
        $deactiveFlashSale = $filterByItemId->update(['status_discount' => 0]);

        return redirect('dashboard/list-discount')->with('flashsale-failed', 'Item Discount has been deactivated');
    }
}
