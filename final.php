<?php
ob_start();
//  this ob_start je debug, nemas ho ukonceny, checkni gfx book page 561
require('./htdocs/includes/config.php');

session_start();
$uid = session_id();

if (!isset($_SESSION['customer_id'])) {
  //    perhaps..
  //    $location = /*'https://' . */BASE_URL . 'checkout.php';
  $location = /*'https://' . BASE_URL . */'checkout.php';
  header("Location:$location");
  exit();
} elseif (
  !isset($_SESSION['response_code']) ||
  ($_SESSION['response_code'] != 1)
) {
  //  perhaps
  $location = /*'https://' . BASE_URL . */'billing.php';
  $location = /*'https://' . */BASE_URL . 'billing.php';
  header("Location:$location");
  exit();
}

require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

//  replace stored procedures with prepared statements
//  $r = mysqli_query($dbc, "CALL clear_cart('$uid')");
//  $r = $pdo->query("CALL clear_cart('$uid')");

$r = $pdo->prepare($clear_cart);
$r->execute(array(
      
      ':uid' => $uid,
      
    ));
//  not yet implemented <TODO> receipt
//  include('./htdocs/includes/email_receipt.php');

$page_title = 'Coffee - Checkout - Your Order is Complete';

//  include('./htdocs/includes/checkout_header.html');
include('./htdocs/includes/header.html');

include('./htdocs/views/final.html');

$_SESSION = array();
session_destroy();

include('./htdocs/includes/footer.html');
?>


