<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountProduct;
use App\Models\FlashSale;
use App\Models\FlashsaleDiscountItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function handleFlashSale(Request $request) {
        $validation = $request->validate([
            'name_flashsale'    => 'required|unique:flash_sales,name_flashsale',
            'start_time'        => 'required_without:end_time',
            'end_time'          => 'required_without:start_time'
        ], [
            'name_flashsale.required'       => 'Name Flashsale must be filled',
            'name_flashsale.unique'         => 'Name Flashsale already taken',
            'start_time.required_without'   => 'Start Time or End Time must be filled',
            'end_time.required_without'     => 'Start Time or End Time must be filled',
        ]);

        DB::beginTransaction();
        try {
            // flashsale is only allowed to be made once.
            if (FlashSale::count() >= 1) {
                return redirect()->back()->with('flashsale-failed', 'In One Period, Only One Flashsale May Take Place Until The Previous Flash Sale Ends.');
            }

            $item_ids = explode(",", $request->item_ids[0]);
            $flashsaleIsCreated = FlashSale::create([
                'name_flashsale'        => $request->name_flashsale,
                'start_time'   => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            DB::commit();

            $syncToPivot = $flashsaleIsCreated->items_flashsale()->sync($item_ids);

            return redirect()->back()->with('flashsale', 'Flashsale Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('flashsale-failed', 'ERROR SERVER: ' . $th->getMessage());
        }    
    }

    public function activateFlashsale($flashsale_id) {
        try {
            $flashsale = FlashSale::whereId($flashsale_id)->first();

            $flashsale->update([
                'is_flash_sale' => 1
            ]);

            return redirect()->back()->with('flashsale', $flashsale->name_flashsale . ' Activated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('flashsale-failed', 'ERROR SERVER: ' . $th->getMessage());
        }
    }

    public function deactiveFlashsale($flashsale_id) {
        try {
            $flashsale = FlashSale::whereId($flashsale_id)->first();
            $flashsale->update([
                'is_flash_sale' => 0
            ]);

            return redirect()->back()->with('flashsale-failed', $flashsale->name_flashsale . ' Deactivated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('flashsale-failed', 'ERROR SERVER: ' . $th->getMessage());
        }
    }

    public function deleteFlashsale($flashsale_id) {
        $now = Carbon::now()->toDateTimeString();
        $flashsale = FlashSale::whereId($flashsale_id)->first();
        // Check if flashsale is active && today = between start_time + end_time
        if ($now >= $flashsale->start_time && $now <= $flashsale->end_time && $flashsale->is_flash_sale) {
            return redirect()->back()->with('flashsale-warning', 'Flash sales may not be deleted while they are still ongoing.');
        } else {
            $flashsale->items_flashsale()->detach();
            $flashsale->delete();
    
            return redirect()->back()->with('flashsale-failed', 'Flashsale Successfully Deleted.');
        }
    }
}
