<?php

use Carbon\Carbon;

// Convert Number Into Cash Format
function Cash($number, $decimal = null) {
  $convert = number_format($number, $decimal);
  return $convert;
}

// Convert Date
function DateFormat($date, $format = null) {
  $convert = Carbon::parse($date)->format($format);
  return $convert;
}
?>