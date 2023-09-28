<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationApiController extends BaseApiController
{
    public function getAllNotifications() {
        try {
            $notifications = DB::table('notifications')
                                ->selectRaw("id, notif_title, notif_slug, notif_description, type_notif, notif_img")
                                ->paginate(3);
            return $this->success_response("Get Notification Successfully", 200, $notifications);
        } catch (\Throwable $th) {
            return $this->failed_response("ERROR SISI SERVER: " . $th->getMessage());
        }

    }
}
