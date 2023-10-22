<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Services\Marketplace\Digiflazz\DigiflazzServices;
use Illuminate\Http\Request;

class MarketplaceApiController extends BaseApiController
{
    protected $marketplace;

    public function __construct() {
        $this->initializeProvider();
    }

    private function initializeProvider() {
        $provider = Provider::where("status", 1)->first();
        if (is_null($provider)) {
            throw new \Exception("Provider Marketplace Not Found");
        }
        switch ($provider->provider_name) {
            case 'Digiflazz':
                $this->marketplace = new DigiflazzServices($provider);
                break;
        }
    }
    
    public function transactionTopUpMarketplace(Request $request) {
        try {
            $provider = $this->marketplace;
            $providerTransaction = $provider->transactionMarketplace(json_decode($request->getContent(), true));
           
            return $this->success_response('Transaction Has Been Created', 200, $providerTransaction);
        } catch (\Exception $e) {
            return $this->failed_response('ERROR IN SERVERDIE: ' . $e->getMessage());
        }
    }

    public function callbackMarketplace(Request $request) { 
        try {
           $provider = $this->marketplace;
           $callbackMarketplace = $provider->handleCallbackMarketplace(json_decode($request->getContent(), true), $request->header());

           return $this->success_response('Callback Marketplace Sukses Ter-handle', 200, ['update_status_order' => $callbackMarketplace]);
        } catch (\Exception $e) {
           return $this->failed_response('ERROR IN SERVERDIE: ' . $e->getMessage());
        }
    }
}
