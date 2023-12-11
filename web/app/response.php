<?php

session_start();

/**
 * Redirects the user to a specified URL with success and message parameters.
 *
 * @param bool $success The success status of the response.
 * @param string $message The message to be included in the response.
 * @param string $url The URL to redirect the user to.
 * @return void
 */
function respond($success, $message, $url)
{
  if (stripos($url, '?') === false) {
    $url .= '?';
  } else {
    $url .= '&';
  }

  $_SESSION['mensaje'] = $message;

  header("Location: {$url}success=$success");
}
