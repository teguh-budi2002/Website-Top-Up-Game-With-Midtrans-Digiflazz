<?php

namespace App\Services\CheckIDGames;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class CheckIDGames {

  protected static $endpoint = 'https://order-sg.codashop.com/initPayment.action';
  protected $requirement_id;
  protected $requirement_price;

  public function checkIDGame($codeGameName, $idGame, $zoneId = '') {
       $this->adjustPayloadRequirements($codeGameName);
       $payload = [
            'voucherPricePoint.id'              => $this->requirement_id ?? null,
            'voucherPricePoint.price'           => $this->requirement_price ?? null,
            'voucherPricePoint.variablePrice'   => 0,
            'n'                                 => '12/7/2022-1853',
            'email'                             => '',
            'userVariablePrice'                 => 0,
            'order.data.profile'                => 'eyJuYW1lIjoiICIsImRhdGVvZmJpcnRoIjoiIiwiaWRfbm8iOiIifQ==',
            'user.userId'                       => $idGame,
            'user.zoneId'                       => $zoneId,
            'msisdn'                            => '',
            'voucherTypeName'                   => strtoupper($codeGameName),
            'shopLang'                          => 'id_ID',
            'voucherTypeId'                     => 5,
            'gvtId'                             => 19,
            'checkoutId'                        => '',
            'affiliateTrackingId'               => '',
            'impactClickId'                     => '',
            'anonymousId'                       => ''
        ];

        $response = self::RequestAPI($payload);
        return $response;
  }

  private function adjustPayloadRequirements($gameName) {
    $game = strtoupper(str_replace(" ", "_", $gameName));
    if ($game === 'VALORANT') {
        $this->requirement_id = 75194;
        $this->requirement_price = 250000.0;
    } elseif ($game === 'MOBILE_LEGENDS') {
        $this->requirement_id = 27670;
        $this->requirement_price = 242535.0;
    } elseif ($game === 'EIGHT_BALL_POOl') {
        $this->requirement_id = 272568;
        $this->requirement_price = 350000.0;
    } elseif ($game === 'APEX_LEGENDS') {
        $this->requirement_id = 293464;
        $this->requirement_price = 629000.0;
    } elseif ($game === 'AOV') {
        $this->requirement_id = 270229;
        $this->requirement_price = 5000000.0;
    } elseif ($game === 'AUTO_CHESS') {
        $this->requirement_id = 203913;
        $this->requirement_price = 1000000.0;
    } elseif ($game === 'BAD_LANDERS') {
        $this->requirement_id = 124082;
        $this->requirement_price = 423000.0;
    } elseif($game === 'CALL_OF_DUTY') {
        $this->requirement_id = 46221;
        $this->requirement_price = 500000.0;
    }  elseif ($game === 'CA_HEROGAMES') {
        $this->requirement_id = 3745;
        $this->requirement_price = 300000.0;
    } elseif ($game === 'DRAGON_CITY') {
        $this->requirement_id = 254278;
        $this->requirement_price = 479000.0;
    } elseif ($game === 'DRAGON_CITY') {
        $this->requirement_id = 75616;
        $this->requirement_price = 450000.0;
    } elseif ($game === 'ZULONG_DRAGON_RAJA') {
        $this->requirement_id = 75616;
        $this->requirement_price = 450000.0;
    } elseif ($game === 'EOS_RED') {
        $this->requirement_id = 182201;
        $this->requirement_price = 340825.0;
    } elseif ($game === 'FOOTBALL_MASTER') {
        $this->requirement_id = 185386;
        $this->requirement_price = 500000.0;
    } elseif ($game === 'FREEFIRE') {
        $this->requirement_id = 8159;
        $this->requirement_price = 300000.0;
    } elseif ($game === 'GENSHIN_IMPACT') {
        $this->requirement_id = 116101;
        $this->requirement_price = 479000.0;
    } elseif ($game === 'HIGGS') {
        $this->requirement_id = 27642;
        $this->requirement_price = 250000.0;
    } elseif ($game === 'IDENTITY_V') {
        $this->requirement_id = 59687;
        $this->requirement_price = 435000.0;
    } elseif ($game === 'WILD_RIFT') {
        $this->requirement_id = 372111;
        $this->requirement_price = 360000.0;
    } elseif ($game === 'NETEASE_LIFEAFTER') {
        $this->requirement_id = 45768;
        $this->requirement_price = 424000.0;
    } elseif ($game === 'LORDS_MOBILE') {
        $this->requirement_id = 50032;
        $this->requirement_price = 250000.0;
    } elseif ($game === 'MARVEL_DUEL') {
        $this->requirement_id = 62214;
        $this->requirement_price = 280978.0;
    } elseif ($game === 'MARVEL_SUPER_WAR') {
        $this->requirement_id = 52439;
        $this->requirement_price = 299000.0;
    } elseif ($game === 'SPEED_NO_LIMIT') {
        $this->requirement_id = 78140;
        $this->requirement_price = 291200.0;
    } elseif ($game === 'ONE_PUNCH_MAN') {
        $this->requirement_id = 77800;
        $this->requirement_price = 440000.0;
    } elseif ($game === 'ONMYOJI_ARENA') {
        $this->requirement_id = 46451;
        $this->requirement_price = 283000.0;
    } elseif ($game === 'POINT_BLANK') {
        $this->requirement_id = 54774;
        $this->requirement_price = 330000.0;
    } elseif ($game === 'GRAVITY_RAGNAROK_M') {
        $this->requirement_id = 127103;
        $this->requirement_price = 300000.0;
    } elseif ($game === 'RAGNAROK_X') {
        $this->requirement_id = 195803;
        $this->requirement_price = 330000.0;
    } elseif ($game === 'RAGNAROK_X') {
        $this->requirement_id = 12837;
        $this->requirement_price = 300000.0;
    } elseif ($game === 'SUPER_MECHA_CHAMPIONS') {
        $this->requirement_id = 37800;
        $this->requirement_price = 283000.0;
    } 
  }

  protected static function setHeader() {
    return $header = [
      'Content-Type: application/json',
      'Origin: https://www.codashop.com',
      'Referer: https://www.codashop.com/',
      'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.63 Mobile Safari/537.36',
    ];
  }

  protected static function RequestAPI($payload) {

    try {
      $client = new Client();
      $response = $client->post(self::$endpoint, [
       'headers' => self::setHeader(),
       'json'    => $payload
      ]);
 
      return json_decode($response->getBody(), TRUE);
    } catch (BadResponseException $br) {
      throw new Exception("ERROR CHECK ID GAME: " . $br->getMessage());
    }
  }
}