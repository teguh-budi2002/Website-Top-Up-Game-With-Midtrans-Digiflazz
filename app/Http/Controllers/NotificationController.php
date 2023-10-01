<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Rules\ImageRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
  public function addOrUpdateNotif(Request $request) {
    $validation = $request->validate([
      'notif_title'         =>  'required|max:45',
      'notif_description'   =>  'required',
      'type_notif'          =>  'required',
      'notif_img'           =>  ['image', 'max:2048', new ImageRule],
    ], [
      'notif_title.required'        =>  'Title Notification Must Be Not Null.',
      'notif_title.max'             =>  'Title Notification Length Is Too Long, Max 45 Chars',
      'notif_description.required'  =>  'Description Notification Must Be Not Null',
      'type_notif.required'         =>  'Please Select Type of Notification',
      'notif_img.uploaded'          =>  'Maximum Image Size Allowed Is 2MB',
    ]);
    try {
        $file = $request->file('notif_img');
        $filename = null;
        $oldFile = $request->old_notif_img;

        if ($file) {
            $filename = $file->getClientOriginalName();
            $path = "page/notification/";				
            $this->deleteOldImage($request->notif_slug);

            $putImgIntoStorage = Storage::putFileAs('/public/page/notification/', $file, $filename);
        }

        Notification::updateOrCreate(
          ['notif_slug' => $request->notif_slug],
          [
            'notif_title'       =>  $request->notif_title,
            'notif_slug'        =>  Str::slug($request->notif_title),
            'notif_description' =>  $request->notif_description,
            'type_notif'        =>  $request->type_notif,
            'notif_img'         =>  $filename ? $filename : $oldFile,
          ]
        );

        return redirect()->back()->with('notification', 'Notification Has Been Created Successfully');
    } catch (\Throwable $th) {
        return redirect()->back()->with('notification-failed', 'Failed Create Notification: ' . $th->getMessage());
    }
   
  }

  protected function deleteOldImage($slug) {
      $notifImg = Notification::select("id", "notif_img")->where('notif_slug', $slug)->first();
      if (!is_null($notifImg)) {
        $fileToDelete = public_path("storage/page/notification/" . $notifImg->notif_img);
        if (file_exists($fileToDelete) && is_file($fileToDelete)) {
              $deleteOldImgNotif = unlink(public_path("storage/page/notification/" . $notifImg->notif_img));
        }
      }
	}

  public function displayNotif($slug) {
    if (!Notification::whereNotifSlug($slug)->first()) {
       return redirect('/');
    }

    $getNotifBySlug = Notification::whereNotifSlug($slug)->first();

    return view('Notification', ['notif' => $getNotifBySlug]);
  }
}
