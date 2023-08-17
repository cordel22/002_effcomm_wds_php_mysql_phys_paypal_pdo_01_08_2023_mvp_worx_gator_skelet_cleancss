
<?php
require('./htdocs/includes/config.php');

//  $_COOKIE['SESSION']
require_once('htdocs/misc/wish_session.php');


$page_title = 'Coffee - Your Wish List';
include('./htdocs/includes/header.html');

require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

include('./htdocs/includes/product_functions.inc.php');

if (isset($_GET['sku'])) {
  list($sp_type, $pid) = parse_sku($_GET['sku']);
}

if (isset($sp_type, $pid, $_GET['action']) && ($_GET['action'] == 'add')) {
  //  $r = mysqli_query($dbc, "CALL remove_from_wish_list('$uid','$sp_type',$pid)");
  //  replace stored procedures with prepared statements
  //  $r = $pdo->query("CALL remove_from_wish_list('$uid','$sp_type',$pid)");
  $r = $pdo->prepare($remove_from_wish_list);
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
  //  $r = mysqli_query($dbc, "CALL add_to_wish_list('$uid','$sp_type',$pid,$qty)");
  //  $r = mysqli_query($dbc, "CALL remove_from_cart('$uid','$sp_type',$pid)");
  //  replace stored procedures with prepared statements
  //  $r = $pdo->query("CALL add_to_wish_list('$uid','$sp_type',$pid,$qty)");
  //  $r = $pdo->query("CALL remove_from_cart('$uid','$sp_type',$pid)");
  /*  debug
  echo "qty = $qty";
  debug */
  /*  
  $r = $pdo->prepare($add_to_wish_list);
  $r->execute(array(
    
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,
    ':qty' => $qty
  ));

  decompose like add_to_cart  */

  $whats_cid = $pdo->prepare($wish_cid);
  $cid = $whats_cid->execute(array(
    
    ':uid' => $uid,
    
    ':type' => $sp_type, 
    ':pid' => $pid,
    
  ));
  $assoc = $whats_cid->fetch(PDO::FETCH_ASSOC);
  $cid = (int) $assoc['id'];
    
  if ($cid > 0) {
    $r = $pdo->prepare($wish_update);
    $r->execute(array(
      ':cid' => $cid,
      
      ':qty' => 1
    ));
    
  } else {
    $r = $pdo->prepare($wish_setup);
    $r->execute(array(
      
      ':uid' => $uid,
      ':type' => $sp_type, 
      ':pid' => $pid,
      ':qty' => $qty
    ));
  }


  $r = $pdo->prepare($remove_from_cart);
  $r->execute(array(
    
    ':uid' => $uid,
    ':type' => $sp_type, 
    ':pid' => $pid,
    
  ));

  /* if (!$r) echo mysqli_error($dbc); */
} elseif (isset($_POST['quantity'])) {
  foreach ($_POST['quantity'] as $sku => $qty) {
    list($sp_type, $pid) = parse_sku($sku);
    if (isset($sp_type, $pid)) {
      $qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 0))) ? $qty : 1;
      //  $r = mysqli_query($dbc, "CALL update_wish_list('$uid','$sp_type',$pid,$qty)");
      //  replace stored procedures with prepared statements
      //  $r = $pdo->query("CALL update_wish_list('$uid','$sp_type',$pid,$qty)");

      if ($qty > 0) {
        $r = $pdo->prepare($update_wish_some);
        $r->execute(array(
      
          ':uid' => $uid,
          ':type' => $sp_type, 
          ':pid' => $pid,
          ':qty' => $qty
        ));
      } else {
        $r = $pdo->prepare($update_wish_none);
        $r->execute(array(
      
          ':uid' => $uid,
          ':type' => $sp_type, 
          ':pid' => $pid,
          ':qty' => $qty
        ));
      }

    }
  }
} //  END OF MAIn IF.
/*    u aint using stored procedures anymore actually so buck that
echo ' actually, the get_wish_list_contents dont exist but are similar to the cart procedure\n
  so u still gotta build em\n';
  u aint using stored procedures anymore  */
//  replace stored procedures with prepared statements
//  $r = mysqli_query($dbc, "CALL get_wish_list_contents('$uid')");

$r = $pdo->prepare($get_wish_list_contents);
      $r->execute(array(
    
        ':uid' => $uid,
      ));

$row_count = $r->rowCount();
/*  debug
if (mysqli_num_rows($r) > 0) {  */
if ($row_count > 0) {
  include('./htdocs/views/wishlist.html');
} else {  //  Empty crt!    
  //  u dont have wishlist.html as yet
include('./htdocs/views/emptylist.html');
//  a\ tu konci debug: 
}
include('./htdocs/includes/footer.html');
?>