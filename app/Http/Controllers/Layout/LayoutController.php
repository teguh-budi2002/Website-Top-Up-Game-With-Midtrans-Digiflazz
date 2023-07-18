<?php

namespace App\Http\Controllers\Layout;

use App\Models\NavLayout;
use App\Models\BannerLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LayoutController extends Controller
{
    /*
    | ---------------------------------------
    | Handle Navigation Layout
    | ---------------------------------------
    */

    /**
     * Edit Text Navigation
     */
    public function editTextHeadingNav() {
        return view('dashboard.views.edit_layout.edit-nav');
    }

    /**
     * Handle Edit Text Navigation
     */
    public function editTextHeadingNavProcess(Request $request) {
        $validation = $request->validate([
            'text_head_nav' => 'required|max:30'
        ], [
            'text_head_nav.required' => 'Input Kolom Tidak Boleh Kosong',
            'text_head_nav.max' => 'Maksimal Karakter Adalah 30'
        ]);

        if (NavLayout::count() >= 1) {
            $oldestNavLayout = NavLayout::oldest()->first();
            $oldestNavLayout->delete();
        }

        NavLayout::create($validation);

        return redirect()->back()->with('edit_nav_layout_success', 'Edit Layout Navigation Sukses');
    }

    /*
    | ---------------------------------------
    | Handle Main Layout
    | ---------------------------------------
    */

    public function editMainLayout() {
        return view('dashboard.views.edit_layout.edit_main');
    }

    /**
     * -------------------------------------
     * Banner Layout
     * -------------------------------------
     */
    public function editMainBannerLayout(Request $request) {
        $validation = $request->validate([
            'img_url' => 'required',
            'img_url.*' => 'required|url'
        ], [
            'img_url.required' => 'Input URL Image Tidak Boleh Kosong.', 
            'img_url.*.required' => 'Input URL Image Tidak Boleh Kosong.', 
            'img_url.*.url' => 'Mohon Masukkan URL Image Yang Valid.'
        ]);

        if (BannerLayout::count() >= 1) {
            $oldestBannerLayout = BannerLayout::oldest()->first();
            $oldestBannerLayout->delete();
        }

        BannerLayout::create([
            'img_url' => $request->input('img_url')
        ]);
        return redirect()->back()->with('edit_banner_layout_success', 'Edit Banner Layout Sukses');
    }

    public function getBannerLayout() {
        $getBanner = BannerLayout::select("id", "img_url")->first();
        return response()->json([
            'message' => 'Get Banner Layout Success',
            'banner' => $getBanner
        ], 200);
    }
}
