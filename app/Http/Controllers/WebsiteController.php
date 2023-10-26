<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Rules\ImageRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function settingCustomOrderPage(Request $request) {
        $img = $request->file('bg_img_on_order_page');
        $oldImg = $request->get('oldImg');
        $slug = $request->slug;
        $path = "";
        $filename = "";
        $request->validate([
            'bg_img_on_order_page' => ['image', 'max:2048', new ImageRule]
        ],[
						'bg_img_on_order_page.uploaded' => 'Maximum image size allowed is 2MB',
						'bg_img_on_order_page.image'    => 'The Uploaded File Must be an Image.',
				]);

        if ($img) {
            $filename = $img->getClientOriginalName();
            $path = "page/custom_bg_image/" . $slug . "/";
            $customField = CustomField::select("id", "bg_img_on_order_page")->wherepageSlug($slug)->first();
            if ($customField) {
              $deleteOldCustomBgImage = self::deleteOldImage($customField, public_path("storage/" . $customField->bg_img_on_order_page));
            }				

            $putImgIntoStorage = Storage::putFileAs('/public/page/custom_bg_image/' . $slug . "/", $img, $filename);
        }
        
        $customField = CustomField::updateOrCreate(
            ['page_slug' => $slug],
            [
                'text_title_on_order_page' => $request->get('text_title_on_order_page'),
                'has_zone_id' => $request->has('has_zone_id') ? 1 : 0,
                'description_on_order_page' => $request->get('description_on_order_page'),
                'detail_for_product' => $request->get('detail_for_product'),
                'page_slug' => $slug,
                // Handle If Any OldImage
                'bg_img_on_order_page' => $img ? $path . $filename : $oldImg
            ]
        );

				return redirect()->back()->with('success-custom-field', 'Custom Field Has Been Addedd Successfully');
    }
}
