<?php

namespace App\Http\Controllers\Layout;

use App\Models\NavLayout;
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
}
