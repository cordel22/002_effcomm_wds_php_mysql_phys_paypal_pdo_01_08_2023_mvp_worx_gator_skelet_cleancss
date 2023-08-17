<?php
require('../includes/config.php');
$page_title = 'Add Inventory';
include('./includes/header.html');
require(MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['add']) && is_array($_POST['add'])) {
    require('../includes/product_functions.inc.php');
    /* 
    $q1 = 'UPDATE specific_coffees SET stock=stock+? WHERE id=?';
    $q2 = 'UPDATE non_coffee_products SET stock=stock+? WHERE id=?';

    $stmt1 = mysqli_prepare($dbc, $q1);
    $stmt2 = mysqli_prepare($dbc, $q2);

    mysqli_stmt_bind_param($stmt1, 'ii', $qty, $id);
    mysqli_stmt_bind_param($stmt2, 'ii', $qty, $id);
 */
    $q1 = 'UPDATE specific_coffees SET stock=stock+:qty WHERE id=:id';
    $q2 = 'UPDATE non_coffee_products SET stock=stock+:qty WHERE id=:id';

    $stmt1 = $pdo->prepare($q1);
    $stmt2 = $pdo->prepare($q2);

    $stmt1->bindParam(':qty', $qty);
    $stmt1->bindParam(':id', $id);

    $stmt2->bindParam(':qty', $qty);
    $stmt2->bindParam(':id', $id);


    $affected = 0;
    foreach ($_POST['add'] as $sku => $qty) {
      if (filter_var($qty, FILTER_VALIDATE_INT, array('min_range' => 1))) {
        list($type, $id) = parse_sku($sku);
        if ($type == 'coffee') {
          //  mysqli_stmt_execute($stmt1);
          $stmt1->execute();
          //$affected += mysqli_stmt_affected_rows($stmt1);
          $affected += $stmt1->rowCount();
        } elseif ($type == 'other') {
          //  mysqli_stmt_execute($stmt2);
          $stmt2->execute();
          //  $affected += mysqli_stmt_affected_rows($stmt1);
          $affected += $stmt2->rowCount();
        }
      }   //  End of IF.
    }     //  End of FOREACH.
    echo "<h4>$affected Items(s) Were Updated!</h4>";
  }   //  End of $_POST['add'] IF.
}     //  End of the submission IF.
?>
<h3>Add Inventory</h3>
<form action="add_inventory.php" method="post" accept-charset="utf-8">
  <fieldset>
    <legend>Indicate how many additionl quantity of each
      product should be added to the inventory.</legend>

    <table border="0" width="100%" cellspacing="4" cellpadding="4">
      <thead>
        <tr>
          <th align="right">Item</th>
          <th align="right">Normal Price</th>
          <th align="right">Quantity in Stock</th>
          <th align="center">Add</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //  sc.size changed to sc.size_id
        $q = '(SELECT CONCAT("O", ncp.id) AS sku, ncc.category, ncp.name,
            ncp.price, ncp.stock FROM non_coffee_products AS ncp INNER JOIN
            non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id
            ORDER BY category,name) UNION (SELECT CONCAT("C", sc.id),
            gc.category, CONCAT_WS("-", s.size, sc.caf_decaf, sc.ground_whole),
            sc.price, sc.stock FROM specific_coffees AS sc INNER JOIN sizes AS
            s ON s.id=sc.size_id INNER JOIN general_coffees AS gc ON
            gc.id=sc.general_coffee_id ORDER BY sc.general_coffee_id, sc.size_id,
            sc.caf_decaf, sc.ground_whole)';
        //  $r = mysqli_query($dbc, $q);
        $r = $pdo->query($q);

        //  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>
              <td align="right">' . $row['category'] . '::' . $row['name'] . '</td>
              <td align="center">' . $row['price'] . '</td>
              <td align="center">' . $row['stock'] . '</td>
              <td align="center"><input type="text" name="add[' . $row['sku'] .
            ']" id="add[' . $row['sku'] . ']" size="5" class="small" /></td>
              </tr>';
        }
        ?>
      </tbody>
    </table>
    <div class="field"><input type="submit" value="Add The
        Inventory" class="button" /></div>
  </fieldset>
</form>

<?php include('./includes/footer.html'); ?>