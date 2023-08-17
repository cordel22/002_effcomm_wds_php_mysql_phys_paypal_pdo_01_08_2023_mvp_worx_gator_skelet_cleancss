
<?php
require('./htdocs/includes/config.php');
$page_title = 'Coffee - Wouldn\'t You Love a Cup Right Now?';
include('./htdocs/includes/header.html');
require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

//  $r = mysqli_query($dbc, "CALL select_sale_items(false)");
//  replace stored procedures with prepared statements
//  $r = $pdo->query("CALL select_sale_items(false)");


    $r = $pdo->query($select_sale_nall);
  

include('./htdocs/views/home.html');
include('./htdocs/includes/footer.html');

?>
