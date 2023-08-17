<?php
ob_start();
//  this ob_start je debug, nemas ho ukonceny, checkni gfx book page 561
require('./htdocs/includes/config.php');

//  session
require_once('htdocs/utils/billing_session.php');


require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');
$billing_errors = array();

//  REQUEST_METHOD IF = POST
require_once('htdocs/misc/billing_post.php');




$page_title = 'Coffee - Checkout - Your Billing Information';
include('./htdocs/includes/checkout_header.html');

//  $r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
//  replace stored procedures with prepared statements
//  $r = $pdo->query("CALL get_shopping_cart_contents('$uid')");
$r = $pdo->prepare($get_shopping_cart_contents);
      $r->execute(array(
    
        ':uid' => $uid,
      ));

$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) > 0) {
if ($row_count > 0) {
  if (
    isset($_SESSION['shipping_for_billing']) &&
    ($_SERVER['REQUEST_METHOD'] != 'POST')
  ) {
    $values = 'SESSION';
  } else {
    $values = 'POST';
  }
  include('./htdocs/views/billing.html');
} else {  //  Empty cart!
  include('./htdocs/views/emptycart.html');
}

include('./htdocs/includes/footer.html');
?>
