<?php

namespace App\Helpers;

class Server
{
  public static function getReferer()
  {
    $referer = $_SERVER['HTTP_REFERER'];

    // clean url
    $referer = str_replace(['http://', 'https://', $_SERVER['HTTP_HOST']], '', $referer);

    return $referer;
  }
}
