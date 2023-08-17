<?php
require('../includes/config.php');
$page_title = 'Add Specific Coffees';
include('./includes/header.html');
require(MYSQL);

$count = 10;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['category']) && filter_var(
    $_POST['category'],
    FILTER_VALIDATE_INT,
    array('min_range' => 1)
  )) {
    /* 
    $q = 'INSERT INTO specific_coffees (general_coffee_id, size_id,
          caf_decaf,ground_whole,price,stock) VALUES (?,?,?,?,?,?)';
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param(
      $stmt,
      'iissdi',
      $_POST['category'],
      $size,
      $caf_decaf,
      $ground_whole,
      $price,
      $stock
    );
 */
    $q = 'INSERT INTO specific_coffees (general_coffee_id, size_id,
    caf_decaf,ground_whole,price,stock) VALUES (:category,:size,:caf_decaf,:gound_whole,:price,:stock)';
    $stmt = $pdo->prepare($q);
    $stmt->bindParam(':category', $_POST['category']);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':caf_decaf', $caf_decaf);
    $stmt->bindParam(':gound_whole', $ground_whole);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock', $stock);


    $affected = 0;
    for ($i = 1; $i <= $count; $i++) {
      if (
        filter_var(
          $_POST['stock'][$i],
          FILTER_VALIDATE_INT,
          array('min_range' => 1)
        )
        && filter_var($_POST['price'][$i], FILTER_VALIDATE_FLOAT)
        && ($_POST['price'][$i] > 0)
      ) {
        $size = $_POST['size'][$i];
        $caf_decaf = $_POST['caf_decaf'][$i];
        $ground_whole = $_POST['ground_whole'][$i];
        $price = $_POST['price'][$i];
        $stock = $_POST['stock'][$i];

        //  mysqli_stmt_execute($stmt);
        $stmt->execute();
        //  $affected += mysqli_stmt_affected_rows($stmt);
        $affected += $stmt->rowCount();
      } //  End of IF.
    }   //  End of FORECH.
    echo "<h4>$affected Products(s) Were Created!</h4>";
  } else {
    echo '<p classs="error">Please select a category.</p>';
  }
}   //  End of the submission IF.
?>
<h3>Add Specific Coffees</h3>
<form action="add_specific_coffees.php" method="post" accept-charset="utf-8">
  <fieldset>
    <legend>Fill out the form to add specific coffee products to the site.
    </legend>
    <div class="field"><label for="category"><strong>General Coffee
          Type</strong></label><br />
      <select name="category">
        <option>Select One</option>
        <?php
        $q = 'SELECT id, category FROM general_coffees ORDER BY category ASC';
        $r = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
          echo "<option value=\"$row[0]\">$row[1]</option>\n";
        }
        ?>
      </select>
    </div>
    <table border="0" width="100%" cellspacing="5" cellpadding="5">
      <thead>
        <tr>
          <th align="right">Size</th>
          <th align="right">Ground/Whole</th>
          <th align="right">Caf./Decaf.</th>
          <th align="center">Price</th>
          <th align="center">Quantity in Stock</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $q = 'SELECT id, size FROM sizes ORDER BY id ASC';
        //  $r = mysqli_query($dbc, $q);
        $r = $pdo->query($q);
        $sizes = '';
        //  while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
        while ($row = $r->fetch(PDO::FETCH_NUM)) {
          $sizes .= "<option value=\"$row[0]\">$row[1]</option>\n";
        }

        $grinds = '<option value="ground">Ground</option>
          <option value="whole">Whole</option>';
        $caf_decaf = '<option value="caf">Caffeinated</option>
          <option value="decaf">Decaffeinted</option>';

        $add_product_errors = array();



        for ($i = 1; $i <= $count; $i++) {
          $price = '<input type="number" id="price[]" class="small" name="price[' . $i . ']">';

          $stock = '<input type="number" id="stock[]" class="small"  name="stock[' . $i . ']">';
          echo '<tr>
            <td align="right"><select name="size[' . $i . ']">' . $sizes . '</select></td>
            <td align="right"><select name="ground_whole[' . $i . ']">' . $grinds . '</select></td>
            <td align="right"><select name="caf_decaf[' . $i . ']">' . $caf_decaf . '</select></td>
            <td align="center">' . $price . '</td>
            <td align="center">' . $stock . '</td>
            </tr>';
        }
        ?>
      </tbody>
    </table>
    <div class="field"><input type="submit" value="Add These Products" class="button" /></div>
  </fieldset>
</form>

<?php include('./includes/footer.html'); ?>