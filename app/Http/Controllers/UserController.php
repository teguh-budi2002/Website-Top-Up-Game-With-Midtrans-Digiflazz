<?php

namespace App\Http\Controllers;

use App\Models\RoleUser;
use App\Models\User;
use App\Services\Whatsapp\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function manage_add_user() {
        $getAllRoles = RoleUser::get();
        return view("dashboard.views.manage_user.add_user", ["roles" => $getAllRoles]);
    }

    public function addUser(Request $request) {
        $validation = $request->validate([ 
            'fullname' => 'required',
            'username' => 'required',
            'email'    => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            User::create($validation);
            DB::commit();

            $sendNotifWA = WhatsappService::typeNotif('user_created')
                                            ->setData(['fullname' => $request->fullname , 'username' => $request->username ,'password' => $request->password, 'role_id' => $request->role_id])
                                            ->sendToCustomer( $request->phone_number);

            return redirect()->back()->with('user','User Successfully Added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('user-failed', 'ERROR SERVERSIDE: ' .  $th->getMessage());
        }
    }
}
