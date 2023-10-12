<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Marketplace\Digiflazz\DigiflazzServices;
use Illuminate\Http\Request;

class MarketplaceApiController extends BaseApiController
{
    protected $marketplace;

    public function __construct()
    {
        $this->marketplace = new DigiflazzServices;
    }
    
    public function transactionTopUpDigiflazz() {
        try {
            $digiflazz = $this->marketplace;
            $digiTransaction = $digiflazz->transactionMarketplace();
           
            return $this->success_response('Transaction Has Been Created', 200, $digiTransaction);
        } catch (\Exception $e) {
            return $this->failed_response('ERROR IN SERVERDIE: ' . $e->getMessage());
        }
    }
}
