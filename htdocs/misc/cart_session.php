


<?php

if (isset($_COOKIE['SESSION'])){
    $uid = $_COOKIE['SESSION'];
  }else{
    $uid = md5(uniqid('biped', true));
  }
  setcookie('SESSION', $uid, time() + (60 * 60 * 24 * 30));