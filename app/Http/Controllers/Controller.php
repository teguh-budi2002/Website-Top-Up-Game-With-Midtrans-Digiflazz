<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function rule_image_validation($file, $allowedMimeTypes = [], $keyMessage, $message) {
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $allowedMimeTypes)) {
            dd("MASUK");
            return redirect()->back()->with($keyMessage, $message);
        } 
    }
}
