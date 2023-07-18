<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    public function settingCustomOrderPage(Request $request, $slug) {
        $img = $request->file('bg_img_on_order_page');
        $path = "";
        $request->validate([
            'bg_img_on_order_page' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ],[
						'bg_img_on_order_page.uploaded' => 'Maximum image size allowed is 2MB'
				]);

        if ($img) {
            $getName = $img->getClientOriginalName();
            $path = "page/custom_bg_image/" . $slug . "/";				
						$this->deleteOldImage($path, $getName, $slug);

            $putImgIntoStorage = Storage::putFileAs('/public/page/custom_bg_image/' . $slug . "/", $img, $getName);
        }
        
        $customField = CustomField::updateOrCreate(
            ['page_slug' => $slug],
            [
                'text_title_on_order_page' => $request->get('text_title_on_order_page'),
                'description_on_order_page' => $request->get('description_on_order_page'),
                'page_slug' => $slug,
                'bg_img_on_order_page' => $path . $getName
            ]
        );

				return redirect()->back()->with('success-custom-field', 'Custom Field Has Been Addedd Successfully');
    }

		protected function deleteOldImage($path, $filename, $slug) {
				$customField = CustomField::select("id", "bg_img_on_order_page")->wherepageSlug($slug)->first();
		
				if (!is_null($customField)) {
					//Check If Any Old BG Image
					if ($customField->bg_img_on_order_page != $path . $filename) {
						// Delete Old Image from Storage
						$deleteOldImg = Storage::disk('public')->delete($customField->bg_img_on_order_page);
					}
				}
		}
}
