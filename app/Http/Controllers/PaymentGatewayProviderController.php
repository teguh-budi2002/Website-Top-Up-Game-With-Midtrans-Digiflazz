<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewayProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentGatewayProviderController extends Controller
{
    public function addOrUpdatePG(Request $request) {
        $validation = $request->validate([
            'payment_name'      => 'required',
            'client_key'        => 'required|unique:payment_gateway_providers,client_key,' . $request->pg_id . '|regex:/^[A-Za-z0-9-_]{10,30}$/',
            'server_key'        => 'required|unique:payment_gateway_providers,server_key,' . $request->pg_id . '|regex:/^[A-Za-z0-9-_]{10,40}$/',
        ], [
            'payment_name.required'     => 'Payment Name Must Be Not Null',
            'client_key.required'       => 'Client Key Must Be Not Null',
            'client_key.unique'         => 'Payment Gateway Client Keys Cannot Be The Same',
            'client_key.regex'          => 'Format Client Key is Invalid',
            'server_key.required'       => 'Server Key Must Be Not Null',
            'server_key.unique'         => 'Payment Gateway Server Keys Cannot Be The Same',
            'server_key.regex'          => 'Format Server Key is Invalid',
        ]);

        DB::beginTransaction();
        try {
            PaymentGatewayProvider::updateOrCreate(
                ['payment_name' => $request->payment_name],
                [
                    'payment_name'  => $request->payment_name,
                    'client_key'    => $request->client_key,
                    'server_key'    => $request->server_key,
                ]
            );
            DB::commit();

            return redirect()->back()->with('pg', 'Setting Payment Gateway Has Been Successfully');
        } catch (\Throwable $th) {
           DB::rollBack();
           return redirect()->back()->with('pg-failed', 'ERROR SERVERSIDE: ' . $th->getMessage());
        }
    }

    public function activatedPG($id) {
        $countPGStatus = PaymentGatewayProvider::where('status', 1)->count();
        if ($countPGStatus >= 1) {
            return redirect()->back()->with('pg-failed', 'Only One Payment Gateway Can Be Active');
        }

        $pg = PaymentGatewayProvider::whereId($id)->first();
        $pg->status = 1;
        $pg->save();

        return redirect()->back()->with('pg', 'Payment Gateway ' . ucfirst($pg->payment_name) . ' Has Been Activated');
    }

    public function deactivePG($id) {
        $pg = PaymentGatewayProvider::whereId($id)->first();
        $pg->status = 0;
        $pg->save();

        return redirect()->back()->with('pg-failed', 'Payment Gateway ' . ucfirst($pg->payment_name) . ' Has Been Deactivated');
    }
}
