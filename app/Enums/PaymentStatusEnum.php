<?php

namespace App\Enums;

enum PaymentStatusEnum:string {

    case Pending = 'Pending';

    case Success = 'Success';

    case Expired = 'Expired';
}