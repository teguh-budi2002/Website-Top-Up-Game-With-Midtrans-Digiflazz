<?php

namespace App\Http\Controllers;

use App\Models\PaymentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentFeeController extends Controller
{
    public function handlePaymentFee(Request $request) {
        $validation = $request->validate([
            'payment_id' => 'required|numeric',
            'fee_flat' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'fee_fixed' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'type_fee' => 'required'
        ], [
            'payment_id.required' => 'Choose One of The Payment Method',
            'payment_id.required' => 'Fee Type Must Be Selected',
            'fee_flat.regex' => 'Fee Flat or Fee Fixed Must Be Filled In And Is a Number',
            'fee_fixed.refex' => 'Fee Flat or Fee Fixed Must Be Filled In And Is a Number',
            'type_fee.required' => 'Choose One of Type Fee'
        ]);
        DB::beginTransaction();
        try {
            PaymentFee::create([
                'payment_id' => $request->payment_id,
                'fee_flat' => $request->fee_flat,
                'fee_fixed' => $request->fee_fixed,
                'type_fee' => $request->type_fee
            ]);

            DB::commit();
            return redirect()->back()->with('success-add-fee', 'Success To Add Payment Fee.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('failed-add-fee', 'Error In Serverside: ', $th->getMessage());
        }
    }
}
