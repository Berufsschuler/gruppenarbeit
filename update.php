<?php
  $count = isset($_COOKIE['cookieCount']) ? intval($_COOKIE['cookieCount']) + 1 : 1;
  setcookie("cookieCount", $count, time() + (86400 * 365), "/");
  echo $count;
?>