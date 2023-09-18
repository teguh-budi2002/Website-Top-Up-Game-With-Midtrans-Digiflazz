<?php

namespace App\Http\Controllers;

use App\Models\PaymentFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentFeeController extends Controller
{
    public function handlePaymentFee(Request $request) {
        // dd($request->all());
        $validation = $request->validate([
            'payment_id'    => 'required|numeric',
            'fee_flat'      => 'required_without:fee_fixed',
            'fee_fixed'     => 'required_without:fee_flat',
            'type_fee'      => 'required'
        ], [
            'payment_id.required'           => 'Choose One of The Payment Method',
            'payment_id.required'           => 'Fee Type Must Be Selected',
            'fee_fixed.required_without'    => "Fee Fixed or Fee Flat must be filled",
            'fee_flat.required_without'     => "Fee Fixed or Fee Flat must be filled",
            'type_fee.required'             => 'Choose One of Type Fee'
        ]);

        if (!empty($request->input('fee_flat')) && !is_numeric($request->input('fee_flat'))) {
            return redirect()->back()->with('failed-add-fee', 'Fee Flat or Fee Fixed Must Be Filled a Number');
        }

        if (!empty($request->input('fee_fixed')) && !is_numeric($request->input('fee_fixed'))) {
            return redirect()->back()->with('failed-add-fee', 'Fee Flat or Fee Fixed Must Be Filled a Number');
        } 
        DB::beginTransaction();
        try {
            PaymentFee::updateOrCreate(
                ['payment_id' => $request->payment_id],
                [
                'payment_id' => $request->payment_id,
                'fee_flat' => $request->fee_flat,
                'fee_fixed' => $request->fee_fixed,
                'type_fee' => $request->type_fee
                ]
            );

            DB::commit();
            return redirect()->back()->with('success-add-fee', 'Success To Add Payment Fee.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('failed-add-fee', 'Error In Serverside: ', $th->getMessage());
        }
    }
}
