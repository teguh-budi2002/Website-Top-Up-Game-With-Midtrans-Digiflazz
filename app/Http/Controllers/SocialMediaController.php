<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SocialMediaController extends Controller
{
    public function addOrUpdateSocialMedia(Request $request) {

        DB::beginTransaction();
        $validation = $request->validate([ 
            "instagram" => "nullable|url|max:55",
            "facebook"  => "nullable|url|max:55",
            "email"     => "nullable|email:dns|max:55",
            "whatsapp"  => "nullable|numeric|digits_between:11,14",
        ], [
            'instagram' => [
                'url' => 'Field Instagram Must Be Valid URL',
                'max' => 'Maximum Character is 55 Chars'
            ],
            'facebook' => [
                'url' => 'Field Facebook Must Be Valid URL',
                'max' => 'Maximum Character is 55 Chars'
            ],
            'email'=> [ 
                'email' => 'Field Email Must Be Valid Email',
                'max' => 'Maximum Character is 55 Chars'
            ],
            'whatsapp' => [
                'numeric' => 'Field Whatsapp Must Be Valid Phone Number',
                'digits_between' => 'Phone Number Format is Between 11 Until 14 Numbers',
            ]
        ]);
        try {
            SocialMedia::updateOrCreate(
                [ 'id' => $request->social_media_id ],
                [
                    'instagram' => $request->instagram,
                    'facebook'  => $request->facebook,
                    'email'     => $request->email,
                    'whatsapp'  => $request->whatsapp,
                ]
            );
            DB::commit();
            return redirect()->back()->with('sosmed', 'Social Media Updated Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('sosmed-failed', 'ERROR SERVERSIDE: ' . $th->getMessage());
        }
    }
}
