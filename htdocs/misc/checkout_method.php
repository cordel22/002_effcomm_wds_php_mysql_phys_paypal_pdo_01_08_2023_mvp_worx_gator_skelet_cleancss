



<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['session'])) {
      $uid = $_GET['session'];
  
      session_id($uid);
      session_start();
    } else {
      $location = /*'http://' . */BASE_URL . 'cart.php';
      header("Location:$location");
      exit();
    }
  } else {  //  POST request.
    session_start();
    $uid = session_id();
  }