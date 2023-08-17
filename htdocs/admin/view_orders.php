<?php
require('../includes/config.php');
$page_title = 'View All Orders';
include('./includes/header.html');
require(MYSQL);
//  TODO test to make sure this script worx. or not
echo '<h3>View Orders</h3><table border="0" width="100%"
    cellspacing="4" cellpadding="4">
    <thead>
      <tr>
      <th align="center">Order ID</th>
      <th align="center">Total</th>
      <th align="right">Customer Name</th>
      <th align="right">City</th>
      <th align="center">State</th>
      <th align="center">Zip</th>
      <th align="center">Left to Ship</th>
      </tr></thead>
    <tbody>';
$q = 'SELECT o.id,total, c.id AS cid, CONCAT(last_name,", ",first_name)
    AS name, city, state, zip, COUNT(oc.id) AS items FROM orders AS o LEFT
    OUTER JOIN order_contents AS oc ON (oc.order_id=o.id AND
    oc.ship_date IS NULL) JOIN customers AS c ON (o.customer_id = c.id)
    JOIN transactions AS t ON (t.order_id=o.id AND t.response_code = 1)
    GROUP BY o.id DESC';
//  missing in the book
//  $r = mysqli_query($dbc, $q);
$r = $pdo->query($q);
//  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
  echo '<tr>
      <td align="center"><a href="view_order.php?oid=' . $row['id'] . '">' .
    $row['id'] . '</a></td>
      <td align="center">$' . $row['total'] . '</td>
      <td align="right">< href="view_customer.php?cid=' . $row['cid'] .
    '">' . $row['name'] . '</a><td>
        <td align="right">$' . $row['city'] . '</td>
        <td align="center">$' . $row['state'] . '</td>
        <td align="center">$' . $row['zip'] . '</td>
        <td align="center">$' . $row['items'] . '</td>
        </tr>';
}
echo '</tbody></table>';

include('./includes/footer.html');
