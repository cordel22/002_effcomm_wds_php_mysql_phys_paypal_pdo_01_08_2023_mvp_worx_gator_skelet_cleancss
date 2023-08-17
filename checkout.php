<?php
ob_start();
//  this ob_start je debug, nemas ho ukonceny, checkni gfx book page 561
require('./htdocs/includes/config.php');

//  get or post method
require_once('htdocs/misc/checkout_method.php');


require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

$shipping_errors = array();


//  the if method=post  validating the inputs and running the queries
require_once('htdocs/misc/checkout_post.php');


$page_title = 'Coffee - Checkout - Your Shipping Information';
include('./htdocs/includes/checkout_header.html');

//  $r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
//  replace stored procedures with prepared statements
//  thatss why comment out nexxt line
//  $r = $pdo->query("CALL get_shopping_cart_contents('$uid')");

$r = $pdo->prepare($get_shopping_cart_contents);
      $r->execute(array(
    
        ':uid' => $uid,
      ));


$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) > 0) {
if ($row_count > 0) {
  include('./htdocs/views/checkout.html');
} else {  //  Empty cart!
  include('./htdocs/views/emptycart.html');
}

include('./htdocs/includes/footer.html');
?>
