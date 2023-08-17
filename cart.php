<?php
ob_start();
//  this ob_start je debug, nemas ho ukonceny, checkni gfx book page 561
require('./htdocs/includes/config.php');

//  $_COOKIE['SESSION']
require_once('htdocs/misc/cart_session.php');



$page_title = 'Coffee - Your Shopping Cart';
include('./htdocs/includes/header.html');

require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

include('./htdocs/includes/product_functions.inc.php');

if (isset($_GET['sku'])) {
  list($sp_type, $pid) = parse_sku($_GET['sku']);
}

if (isset($sp_type, $pid, $_GET['action']) && ($_GET['action'] == 'add')) {
  //  $r = mysqli_query($dbc, "CALL add_to_cart('$uid','$sp_type',$pid,1)");
  //  replace stored procedures with prepared statements
  //  $r = $pdo->query("CALL add_to_cart('$uid','$sp_type',$pid,1)");
  /*	to be separated  
  $r = $pdo->prepare($add_to_cart);
  $r->execute(array(
    
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,
    ':qty' => 1
  ));
  to be separated   */
  $whats_cid = $pdo->prepare($find_cid);
  $cid = $whats_cid->execute(array(
    
    ':uid' => $uid,
    
    ':type' => $sp_type, 
    ':pid' => $pid,
    
  ));
  $assoc = $whats_cid->fetch(PDO::FETCH_ASSOC);
  $cid = (int) $assoc['id'];

  if ($cid > 0) {
    
    $r = $pdo->prepare($cart_update);
    $r->execute(array(
      ':cid' => $cid,
      /*
      ':uid' => $uid,
      ':type' => $sp_type, 
      ':pid' => $pid, */
      ':qty' => 1
    ));
    
  } else {
    //  ???
    //  debug
    //  $r = $pdo->prepare($cart_setup);
    $r = $pdo->prepare("INSERT INTO carts (user_session_id, product_type, product_id,
	quantity) VALUES (:uid, :type, :pid, :qty);");
    //  ???
    //  end debug
    $r->execute(array(
      
      ':uid' => $uid,
      ':type' => $sp_type, 
      ':pid' => $pid,
      ':qty' => 1
    ));
  }
  
  
} elseif (isset($sp_type, $pid, $_GET['action']) && ($_GET['action'] == 'remove')) {
  //  $r = mysqli_query($dbc, "CALL remove_from_cart('$uid','$sp_type',$pid)");
  //  replace stored procedures with prepared statements
  //  $r = $pdo->query("CALL remove_from_cart('$uid','$sp_type',$pid)");
  $r = $pdo->prepare($remove_from_cart);
  $r->execute(array(
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,
  ));
} elseif (
  isset($sp_type, $pid, $_GET['action'], $_GET['qty']) &&
  ($_GET['action'] == 'move')
) {
  $qty = (filter_var(
    $_GET['qty'],
    FILTER_VALIDATE_INT,
    array('min_range' => 1)
  )) ? $_GET['qty'] : 1;
  // $r = mysqli_query($dbc, "CALL add_to_cart('$uid','$sp_type',$pid,$qty)");
  // $r = mysqli_query($dbc, "CALL remove_from_wish_list('$uid','$sp_type',$pid)");
  //  replace stored procedures with prepared statements
  //  $r = $pdo->query("CALL add_to_cart('$uid','$sp_type',$pid,$qty)");

  //  is there a wishlist..?
  
  //  $r = $pdo->query("CALL remove_from_wish_list('$uid','$sp_type',$pid)");
  /*	decompose add t cart like before
  $r = $pdo->prepare($add_to_cart);
  $r->execute(array(
    
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,
    ':qty' => $qty
  ));
  decompose add t cart like before	*/
  
  $whats_cid = $pdo->prepare($find_cid);
  $cid = $whats_cid->execute(array(
    
    ':uid' => $uid,
    
    ':type' => $sp_type, 
    ':pid' => $pid,
    
  ));
  $assoc = $whats_cid->fetch(PDO::FETCH_ASSOC);
  $cid = (int) $assoc['id'];
   
  if ($cid > 0) {
    $r = $pdo->prepare($cart_update);
    $r->execute(array(
      ':cid' => $cid,
      
      ':qty' => 1
    ));
  } else {
    $r = $pdo->prepare($cart_setup);
    $r->execute(array(
      
      ':uid' => $uid,
      ':type' => $sp_type, 
      ':pid' => $pid,
      ':qty' => 1
    ));
  }   //  end of add_cart
  
  
  
  //  $r = $pdo->prepare($remove_from_wish_list);

  $r = $pdo->prepare($remove_from_wish_list);
  $r->execute(array(
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,    
  ));

  //  if (!$r) echo mysqli_error($dbc);
  if (!$r) echo $pdo->errorInfo();
} elseif (isset($_POST['quantity'])) {
  foreach ($_POST['quantity'] as $sku => $qty) {
    list($sp_type, $pid) = parse_sku($sku);
    if (isset($sp_type, $pid)) {
      $qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0))) ? $qty : 1;
      //  $r = mysqli_query($dbc, "CALL update_cart('$uid','$sp_type',$pid,$qty)");
      //  replace stored procedures with prepared statements
      //  $r = $pdo->query("CALL update_cart('$uid','$sp_type',$pid,$qty)");

      if ($qty > 0) {
        $r = $pdo->prepare($update_cart_some);
        $r->execute(array(
      
          ':uid' => $uid,
          ':type' => $sp_type, 
          ':pid' => $pid,
          ':qty' => $qty
        ));
      } else {
        $r = $pdo->prepare($update_cart_none);
        $r->execute(array(
      
          ':uid' => $uid,
          ':type' => $sp_type, 
          ':pid' => $pid,
          ':qty' => $qty
        ));
      }
      /*
      $r = $pdo->prepare($update_cart);
      $r->execute(array(
    
        ':uid' => $uid,
        ':type' => $sp_type, 
        ':pid' => $pid,
        ':qty' => $qty
      ));
      */
    }
  }
} //  END OF MAIn IF.




//  replace stored procedures with prepared statements
//  $r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
//  $r = $pdo->query("CALL get_shopping_cart_contents('$uid')");
//  TODO  to json for async call
$r = $pdo->prepare($get_shopping_cart_contents);
      $r->execute(array(
    
        ':uid' => $uid,
      ));

$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) > 0) {
if ($row_count > 0) {
  include('./htdocs/views/cart.html');
} else {  //  Empty crt!
  include('./htdocs/views/emptycart.html');
}

include('./htdocs/includes/footer.html');
?>
