<?php

namespace App\Services\Marketplace;

abstract class Marketplace {
  abstract public function getProductListFromMarketplace();
  abstract public function transactionMarketplace($callbackNotif);
}