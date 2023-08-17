
<?php
require('./htdocs/includes/config.php');
$page_title = 'Sale Items';
include('./htdocs/includes/header.html');
require(MYSQL);
//  replace stored procedures with prepared statements
include('./htdocs/includes/procedures.php');

//  $r = mysqli_query($dbc, 'CALL select_sale_items(true)');
//  replace stored procedures with prepared statements
//  $r = $pdo->query('CALL select_sale_items(true)');

//  TODO  :   this will go into json for async call from the front
$r = $pdo->query($select_sale_all);

$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) > 0) {
if ($row_count >= 1) {
  include('./htdocs/views/list_sales.html');
} else {
  include('./htdocs/views/noproducts.html');
}
include('./htdocs/includes/footer.html');
?>
