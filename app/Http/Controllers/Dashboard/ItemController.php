<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;

class ItemController extends Controller
{
    public function storeItem(StoreItemRequest $request) {
      $validation = $request->validated();
      DB::beginTransaction();
      try {
        Item::create($validation);
        DB::commit();

        return redirect()->back()->with('create_success', 'Item Success Added Successfully');
      } catch (\Throwable $th) {
        DB::rollback();
        dd($th->getMessage());
        return redirect()->back();
      }
    }
}
