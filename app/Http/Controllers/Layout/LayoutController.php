<?php

namespace App\Http\Controllers\Layout;

use App\Models\NavLayout;
use App\Models\BannerLayout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
        return view('dashboard.views.manage_layout.nav_layout');
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
        $oldBanner = BannerLayout::select("id", "img_url")->first();
        return view('dashboard.views.manage_layout.banner_layout', ['banner' => $oldBanner]);
    }

    /**
     * -------------------------------------
     * Banner Layout
     * -------------------------------------
     */
    public function editMainBannerLayout(Request $request) {
        $validation = $request->validate([
            'images' => 'array|min:1|required',
            'images.*' => 'image|max:2048',
        ], [
            'images.required' => 'Input Image Cannot Be Null.', 
            'images.*.image' => 'The Uploaded File Must be an Image.', 
            'images.*.uploaded' => 'Max File Size is 2MB.',
        ]);
        
        $file_images = $request->images;
        $uploadedImages = [];
        
        foreach ($file_images as $img) {
            $filename = $img->getClientOriginalName();
            $extension = $img->getClientOriginalExtension();
            $path = "page/banner/";
            $this->deleteOldImages($path, $filename);
            
            if (!in_array($extension, ['webp', 'png'])) {
                return redirect()->back()->with('extension-error', 'Allowed Extension For Image (webp, png)');
            }

            $putImgIntoStorage = Storage::putFileAs('/public/page/banner/', $img, $filename);
            $uploadedImages[] = $path . $filename;
        }

        if (BannerLayout::count() >= 1) {
            $oldestBanner = BannerLayout::select("id", "img_url")->oldest()->first(); 
            $oldestBanner->delete();
        }

        BannerLayout::create([
            'img_url' => $uploadedImages
        ]);
        return redirect()->back()->with('edit_banner_layout_success', 'Edit Banner Layout Sukses');
    }

    protected function deleteOldImages($path, $filename) {
        $banners = BannerLayout::select("id", "img_url")->first();
        if (!is_null($banners)) {
            foreach ($banners->img_url as $banner) {
                 //Check If Any Old BG Image
                if ($banner != $path . $filename) {
                    // Delete Old Image from Storage
                    $deleteOldImg = Storage::disk('public')->delete($banner);
                }
            }
        }
	}

    public function getBannerLayout() {
        $getBanner = BannerLayout::select("id", "img_url")->first();
        return response()->json([
            'message' => 'Get Banner Layout Success',
            'banner' => $getBanner
        ], 200);
    }
}
