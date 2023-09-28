<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;

class PaymentController extends Controller
{
    public function handleAddPaymentMethodIntoProduct(Request $request) {
        $paymentMethodIds = $request->payment_method_ids;
        $product = Product::findOrFail($request->product_id);
        
        DB::beginTransaction();
        try {
            // Attaching Payment Method Id's into Pivot Table
            $product->paymentMethods()->sync($paymentMethodIds);
            DB::commit();

            return redirect()->back()->with('success-add-payment-method', 'Successfully Adding Payment Method Into ' . $product->product_name);
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect()->back()->with('error-add-payment-method', 'Ooopss, Something Went Wrong in Serverside! ' . $th->getMessage());
        }
    }

    public function handleRecommendationPaymentMethod(Request $request) {
        $paymentIds = $request->payment_ids;
        $isUpdate = PaymentMethod::whereIn('id', $paymentIds)->update([
            'is_recommendation' => 1
        ]);
        
        return redirect()->back()->with('success-add-payment-method', 'Successfully Updating Recommendation Payment Method.');
    }

    public function handleRemoveRecommendationPaymentMethod($payment_id) {
        $deActiveRecommendation = PaymentMethod::whereId($payment_id)->update([
            'is_recommendation' => 0
        ]);

        return redirect()->back()->with('success-add-payment-method', 'Successfully Updating Recommendation Payment Method.');
    }
}
