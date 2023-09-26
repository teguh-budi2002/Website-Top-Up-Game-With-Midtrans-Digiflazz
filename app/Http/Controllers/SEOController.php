<?php

namespace App\Http\Controllers;

use App\Models\SEO;
use App\Rules\ImageRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SEOController extends Controller
{
  public function addOrUpdateSeo(Request $request) 
  {
    $validation = $request->validate([
      'name_of_the_company'   => 'required',
      'keyword'               => 'required',
      'description'           => 'required',
      'logo_favicon'          => ['image', 'max:2048', new ImageRule],
      'logo_website'          => ['image', 'max:2048', new ImageRule],
    ], [
      'name_of_the_company.required'  => 'Name The Company Cannot Be Null',
      'keyword.required'              => 'Keyword Cannot Be Null',
      'description.required'          => 'Description Cannot Be Null',
      'logo_favicon.uploaded'         => 'Maximum image size allowed is 2MB',
      'logo_favicon.mimes'            => 'Allowed Extension For Image (png, webp)',
      'logo_website.uploaded'         => 'Maximum image size allowed is 2MB',
    ]);

    DB::beginTransaction();
    try {
      $logoFaviconName = '';
      $logoWebsiteName = '';
      $oldLogoFavicon = $request->old_favicon_img;
      $oldLogoWebsite = $request->old_website_img;

      $dataSeo = SEO::select("id", "logo_favicon", "logo_website")->whereId($request->seo_id)->first();
      if($request->hasFile('logo_favicon')) {
          $file = $request->logo_favicon;
          $logoFaviconName = $file->getClientOriginalName();
          $path = "/public/seo/logo/favicon/";
          $this->deleteOldImageFavicon($dataSeo);

          $putLogoFaviconIntoStorage = Storage::putFileAs($path, $file, $logoFaviconName);
      }

      if($request->hasFile('logo_website')) {
          $file = $request->logo_website;
          $logoWebsiteName = $file->getClientOriginalName();
          $path = "/public/seo/logo/website/";
          $this->deleteOldImageWebsite($dataSeo);

          $putLogoWebsiteIntoStorage = Storage::putFileAs($path, $file, $logoWebsiteName);
      }

      SEO::updateOrCreate(
        ['id' => $request->seo_id],
        [
          'name_of_the_company' => $request->name_of_the_company,
          'keyword'             => $request->keyword,
          'description'         => $request->description,
          'logo_favicon'        => $request->logo_favicon ? $logoFaviconName : $oldLogoFavicon,
          'logo_website'        => $request->logo_website ? $logoWebsiteName : $oldLogoWebsite
        ]
      );
      DB::commit();

      return redirect()->back()->with('seo', 'SEO Successfully Added On Website');

    } catch (\Throwable $th) {
      DB::rollBack();

      return redirect()->back()->with('seo-failed', 'ERROR ON SERVERSIDE: ' . $th->getMessage());
    }
  }

  protected function deleteOldImageFavicon($dataSeo) {
      if (!is_null($dataSeo)) {
        $fileToDelete = public_path("storage/seo/logo/favicon/" . $dataSeo->logo_favicon);
        if (file_exists($fileToDelete) && is_file($fileToDelete)) {
              $deleteOldImgFavicon = unlink(public_path("storage/seo/logo/favicon/" . $dataSeo->logo_favicon));

        }
      }
  }
  protected function deleteOldImageWebsite($dataSeo) {
      if (!is_null($dataSeo)) {
        $fileToDelete = public_path("storage/seo/logo/website/" . $dataSeo->logo_website);
        if (file_exists($fileToDelete) && is_file($fileToDelete)) {
          // Delete Old Image from Storage
          $deleteOldImgWebsite = unlink($fileToDelete);
        }
      }
  }
}
