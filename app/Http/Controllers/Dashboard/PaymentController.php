<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function handleAddPaymentMethodIntoProduct(Request $request) {
        $paymentMethodIds = explode(",", $request->payment_method_ids[0]);
        $product = Product::findOrFail($request->product_id);
        
        DB::beginTransaction();
        try {
            // Attaching Payment Method Id's into Pivot Table
            $product->paymentMethods()->attach($paymentMethodIds);
            DB::commit();

            return redirect()->back()->with('success-add-payment-method', 'Successfully Adding Payment Method Into ' . $product->product_name);
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()->back()->with('error-add-payment-method', 'Ooopss, Something Went Wrong in Serverside!');
        }
    }
}
