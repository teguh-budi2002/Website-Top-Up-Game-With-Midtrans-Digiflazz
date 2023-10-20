<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    public function addOrUpdateProvider(Request $request) {
        $validation = $request->validate([
            'provider_name'     => 'required',
            'username'          => 'required|unique:providers,username,' . $request->provider_id . '|regex:/^[A-Za-z0-9-_]{10,30}$/',
            'key'               => 'required|unique:providers,key,' . $request->provider_id . '|regex:/^[A-Za-z0-9-_]{10,40}$/',
        ], [
            'provider_name.required'  => 'Provider Name Must Be Not Null',
            'username.required'       => 'Provider Username Key Must Be Not Null',
            'username.unique'         => 'Provider Username Key Cannot Be The Same',
            'username.regex'          => 'Format Provider Key is Invalid',
            'key.required'            => 'Server Key Must Be Not Null',
            'key.unique'              => 'Provider Server Keys Cannot Be The Same',
            'key.regex'               => 'Format Provider Server Key is Invalid',
        ]);

        DB::beginTransaction();
        try {
            Provider::updateOrCreate(
                ['provider_name' => $request->provider_name],
                [
                    'provider_name'  => $request->provider_name,
                    'username'        => $request->username,
                    'key'            => $request->key,
                ]
            );
            DB::commit();

            return redirect()->back()->with('provider', 'Setting Provider Has Been Successfully');
        } catch (\Throwable $th) {
           DB::rollBack();
           return redirect()->back()->with('provider-failed', 'ERROR SERVERSIDE: ' . $th->getMessage());
        }
    }

    public function activatedProvider($id) {
        $countPGStatus = Provider::where('status', 1)->count();
        if ($countPGStatus >= 1) {
            return redirect()->back()->with('provider-failed', 'Only One Provider Can Be Actived');
        }

        $pg = Provider::whereId($id)->first();
        $pg->status = 1;
        $pg->save();

        return redirect()->back()->with('provider', 'Provider ' . ucfirst($pg->provider_name) . ' Has Been Activated');
    }

    public function deactiveProvider($id) {
        // $oldSettingSupportedPayment = ProductPaymentMethod::exists();
        // if($oldSettingSupportedPayment) {
        //     ProductPaymentMethod::truncate();
        // }
        $pg = Provider::whereId($id)->first();
        $pg->status = 0;
        $pg->save();

        return redirect()->back()->with('provider-failed', 'Provider ' . ucfirst($pg->provider_name) . ' Has Been Deactivated');
    }
}
