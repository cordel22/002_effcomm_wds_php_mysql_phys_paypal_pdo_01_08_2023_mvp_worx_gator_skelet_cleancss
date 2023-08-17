
<?php
require('../includes/config.php');
$page_title = 'View An Order';
include('./includes/header.html');

$order_id = false;
if (isset($_GET['oid']) && (filter_var($_GET['oid'], FILTER_VALIDATE_INT, array('min_range' => 1)))) {
  $order_id = $_GET['oid'];
  $_SESSION['order_id'] = $order_id;
} elseif (isset($_SESSION['order_id']) && (filter_var(
  $_SESSION['order_id'],
  FILTER_VALIDATE_INT,
  array('min_range' => 1)
))) {
  $order_id = $_SESSION['order_id'];
}
if (!$order_id) {
  echo '<h3>Error!</h3><p>This page has been accessed in error.</p>';
  include('./includes/footer.html');
  exit();
}

require(MYSQL);

/*  p 350 / 367
The second script in the payment request process, gateway_process.php,
defines values required by both customer and administrator requests, and
then performs the actual communication with the payment gateway. In that
script, three values are assigned on the fly:
$data['x_amount'] = $order_total;
$data['x_invoice_num'] = $order_id;
$data['x_cust_id'] = $customer_id;
The code for assigning these values needs to be written into view_order.php,
just as it was within billing.php.
Updating view_order.php
The code for processing the payment capture is about 70 lines long, well
spaced, and with comments. You can place it all within an includable file,
or just add it to view_order.php, as in these next steps.
1. Open view_order.php in your text editor or IDE, if it is not already.
2. After including the database connection, check for a form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $q = "SELECT customer_id, total, transaction_id FROM orders AS o JOIN
    transactions AS t ON (o.id=t.order_id AND t.type='AUTH_ONLY' AND
    t.response_code=1) WHERE o.id=$order_id";
  //  $r = mysqli_query($dbc, $q);
  $r = $pdo->query($q);

  $row_count = $r->rowCount();

  //  if (mysqli_num_rows($r) == 1) {   //  in the book is MYSQL(only)_NUM, missing I p 351 / 368
  if ($r->fetch($r) == 1) {
    //  list($customer_id, $order_total, $trans_id) = mysqli_fetch_array($r, MYSQLI_NUM);
    list($customer_id, $order_total, $trans_id) = $r->fetch(PDO::FETCH_NUM);

    /*
    The important thing to note here is that these three variable names
exactly match those expected by the gateway_setup_admin.php and
gateway_process.php scripts.
    */

    if ($order_total > 0) {
      require_once(BASE_URI . 'private/gateway_setup_admin.php');
      require_once(BASE_URI . 'private/gateway_process.php');

      $reason = addslashes($response_array[3]);
      $response = addslashes($response);
      /* $r = mysqli_query($dbc, "CALL add_transaction($order_id,
    '{$data['x_type']}', $response_array[9],$response_array[0],'$reason',
    $response_array[6], '$response')"); */
      $r = $pdo->query("CALL add_transaction($order_id,
    '{$data['x_type']}', $response_array[9],$response_array[0],'$reason',
    $response_array[6], '$response')");

      if ($response_array[0] == 1) {
        $message = 'The payment has been made. You may now ship the order.';

        $q = "UPDATE order_contents SET ship_date=NOW() WHERE order_id=$order_id";
        //  $r = mysqli_query($dbc, $q);
        $r = $pdo->query($q);

        $q = 'UPDATE specific_coffees AS sc, order_contents AS oc SET
    sc.stock=sc.stock-oc.quantity WHERE sc.id=oc.product_id AND
    oc.product_type="coffee" AND oc.order_id=' . $order_id;
        //  $r = mysqli_query($dbc, $q);
        $r = $pdo->query($q);
        $q = 'UPDATE non_coffee_products AS ncp, order_contents AS oc SET
      ncp.stock=ncp.stock-oc.quantity WHERE ncp.id=oc.product_id AND
      oc.product_type="other" AND oc.order_id=' . $order_id;
        //  $r = mysqli_query($dbc, $q);
        $r = $pdo->query($q);
      } else {
        $error = "The payment could not be processed because: $response_array[3]";
      } //  End of payment response IF-ELSE.
    } else {  //  Invalid order total!
      $error = "The order total (\$$order_total) is invalid.";
    } //  End of $order_totl IF-ELSE.
  } else {  //  No mtching order!
    $error = 'No matching order could be found.';
  } //  End of transaction ID IF-ELSE.

  echo '<h3>Order Shipping Results</h3>';
  if (isset($message)) echo "<p>$message</p>";
  if (isset($error)) echo "<p class=\"error\">$error</p>";
}   //  End of the submission IF.

$q = 'SELECT total, shipping, credit_card_number, DATE_FORMAT(
    order_date, "%a %b %e, %Y at %h:%i%p") AS od, email,
    CONCAT(last_name, ", ",first_name) AS name, CONCAT_WS(" ",
    address1, address2, city, state, zip) AS address,phone,customer_id,
    CONCAT_WS("-",ncc.category,ncp.name) AS item,ncp.stock,
    quantity,price_per,DATE_FORMAT(ship_date,"%b %e, %Y") AS sd
    FROM orders AS o INNER JOIN customers AS c ON (o.customer_id = c.id)
    INNER JOIN order_contents AS oc ON (oc.order_id = o.id) INNER JOIN
    non_coffee_products AS ncp ON (oc.product_id = ncp.id AND
    oc.product_type="other") INNER JOIN non_coffee_categories AS ncc
    ON (ncc.id = ncp.non_coffee_category_id) WHERE o.id=' . $order_id . '
    UNION
    SELECT total, shipping, credit_card_number, DATE_FORMAT(
      order_date,"%a %b %e, %Y at %l:%i%p"),email,
      CONCAT(last_name,", ",first_name), CONCAT_WS(" ",address1,
      address2, city, state, zip), phone, customer_id, CONCAT_WS("-",
      gc.category,s.size,sc.caf_decaf,sc.ground_whole) AS item,sc.stock,
      quantity,price_per,DATE_FORMAT(ship_date, "%b %e, %Y") FROM
      orders AS o INNER JOIN customers AS c ON (o.customer_id = c.id)
      INNER JOIN order_contents AS oc ON (oc.order_id = o.id) INNER
      JOIN specific_coffees AS sc ON (oc.product_id = sc.id AND
      oc.product_type="coffee") INNER JOIN sizes AS s ON (s.id=sc.size_id)
      INNER JOIN general_coffees AS gc ON (gc.id=sc.general_coffee_id)
      WHERE o.id=' . $order_id;
//  $r = mysqli_query($dbc, $q);
$r = $pdo->query($q);

$row_count = $r->rowCount();

//  if (mysqli_num_rows($r) > 0) {
if ($row_count >= 1) {
  echo '<h3>View an Order</h3>
    <form action="view_order.php" method="post" accept-charset="utf-8">
    <fieldset>';

  //  $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
  $row = $r->fetch(PDO::FETCH_ASSOC);
  echo "<p><strong>ORDER ID</strong>:$order_id<br /><strong>
      Total</strong>:\${$row['total']}<br /><strong>Shipping
      </strong>:\${$row['shipping']}<br /><strong>Order Date
      </strong>:\${$row['od']}<br /><strong>Customer Name
      </strong>:\${$row['name']}<br /><strong>Customer Address
      </strong>:\${$row['address']}<br /><strong>Customer Email
      </strong>:\${$row['email']}<br /><strong>Customer Phone
      </strong>:\${$row['phone']}<br /><strong>Credit Card Number
      Used</strong>:*{$row['credit_card_number']}</p>";

  echo '<table border="0" width="100%" cellspacing="2" cellpadding="2">
      <thead>
        <tr>
          <th align="center">Item</th>
          <th align="right">Price Paid</th>
          <th align="center">Quantity in Stock</th>
          <th align="center">Quantity Ordered</th>
          <th align="center">Ship?</th>
        </tr>
      </thead>
      <tbody>';

  $shipped = true;

  do {
    echo '<tr>
        <th align="left">' . $row['item'] . '</thd>
        <th align="right">' . $row['price_per'] . '</thd>
        <th align="center">' . $row['stock'] . '</thd>
        <th align="center">' . $row['quantity'] . '</thd>
        <th align="center">' . $row['sd'] . '</td>
      </tr>';
    if (!$row['sd']) $shipped = false;
    //  } while ($row = mysqli_fetch_array($r));
  } while ($row = $r->fetch(PDO::FETCH_ASSOC));

  echo '</tbody></table>';

  if (!$shipped) {
    echo '<div class="field"><p class="error">Note that actual
      payments will be collected once you click this button!</p>
      <input type="submit" value="Ship This Order" class="button" />
      </div>';
  }

  echo '</fieldset>
    </form>';
} else {  //  No records returned!
  echo '<h3>Error!</h3><p>This page has been accessed in error.
    </p>';

  include('./includes/footer.html');
  exit();
}

include('./includes/footer.html');
?>


