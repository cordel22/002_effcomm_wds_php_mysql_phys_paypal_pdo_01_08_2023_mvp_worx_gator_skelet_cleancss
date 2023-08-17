<?php
/* require('./includes/config.inc.php'); */
require('./htdocs/includes/config.php');

if (isset($_GET['type']) && ($_GET['type'] == 'goodies')) {
  $page_title = 'Our Goodies, by Category';
  $sp_type = 'other';
  $type = 'goodies';
} else {  //  Default is coffee!!
  $page_title = 'Our Coffee Products';
  $type = $sp_type = 'coffee';
}
include('./htdocs/includes/header.html');
require(MYSQL);

//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');


//  $r = mysqli_query($dbc, "CALL select_categories('$sp_type')");
//  replace stored procedures with prepared statements
//  $r = $pdo->query("CALL select_categories('$sp_type')");

//  TODO  :   this will go into json for async call from the front
if ($sp_type == 'coffee') {
  $r = $pdo->query($select_cat_coffee);
} else if ($sp_type == 'other') {
  $r = $pdo->query($select_cat_other);
} else {
  echo 'You didn\'t select a category of products!';
}


//  or offline debugging
//  This line will print any MySQL errors that occurred, if $r doesn’t have a positive value.
//  if (!$r) echo mysqli_error($dbc);
if (!$r) echo $pdo->errorInfo();

$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) >= 1) {
if ($row_count > 0) {
  include('./htdocs/views/list_categories.html');
} else {  //  Include the eror page;
  include('./htdocs/views/error.html');
}
include('./htdocs/includes/footer.html');
?>

