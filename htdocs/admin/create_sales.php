<?php
require('../includes/config.php');
$page_title = 'Create Sales';
include('./includes/header.html');
require(MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset(
    $_POST['sale_price'],
    $_POST['start_date'],
    $_POST['end_date']
  )) {
    require('../includes/product_functions.inc.php');

    $q = 'INSERT INTO sales (product_type, product_id, price, start_date, end_date)
          VALUES (?,?,?,?,?)';
    //  TODO change this into PDO!!!
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param($stmt, 'sidss', $type, $id, $price, $start_date, $end_date);

    $affected = 0;
    foreach ($_POST['sale_price'] as $sku => $price) {
      if (
        filter_var($price, FILTER_VALIDATE_FLOAT)
        &&  ($price > 0)
        && (!empty($_POST['start_date'][$sku]))
      ) {
        list($type, $id) = parse_sku($sku);

        $start_date = $_POST['start_date'][$sku];
        $end_date = (empty($_POST['end_date'][$sku])) ? NULL : $_POST['end_date'][$sku];
        mysqli_stmt_execute($stmt);
        $affected += mysqli_stmt_affected_rows($stmt);
      }   //  End of price  / date validation IF.
    }       //  End of FOREACH loop.
    echo "<h4>$affected Sales Were Created!</h4>";
  }     //  $_POST variables aren't set.
}       //  End of the submission IF.
?>
<h3>Create Sales</h3>
<p>
  To mark an item s being on sale, indicate the sale price, the date
  the sale starts, nd the date the sale ends. You may leave the end date
  blank, thereby creating an open-ended sale. Only the Currently
  stocked products are listed below!
</p>
<form action="create_sales.php" method="post" accept-charset="utf-8">
  <fieldset>
    <table border="0" width="100%" cellspacing="2" cellpadding="2">
      <thead>
        <tr>
          <th align="right">Item</th>
          <th align="right">Normal Price</th>
          <th align="right">Quantity in Stock</th>
          <th align="center">Sale Price</th>
          <th align="right">Start Date</th>
          <th align="right">End Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //  sc.size_id
        $q = '(SELECT CONCAT("O", ncp.id) AS sku, ncc.category, ncp.name,
            ncp.price, ncp.stock FROM non_coffee_products AS ncp INNER JOIN
            non_coffee_categories AS ncc ON ncc.id=ncp.non_coffee_category_id
              WHERE ncp.stock > 0 ORDER BY category,name) UNION (SELECT
              CONCAT ("C", sc.id), gc.category, CONCAT_WS("-", s.size,
              sc.caf_decaf, sc.ground_whole), sc.price, sc.stock FROM
              specific_coffees AS sc INNER JOIN sizes AS s ON s.id=sc.size_id
              INNER JOIN general_coffees AS gc ON gc.id=sc.general_coffee_id
              WHERE sc.stock > 0 ORDER BY sc.general_coffee_id, sc.size_id,
              sc.caf_decaf,sc.ground_whole)';
        $r = mysqli_query($dbc, $q);

        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
          echo '<tr>
            <td align="center">' . $row['category'] . '::' . $row['name'] . '</td>
            <td align="center">' . $row['price'] . '</td>
            <td align="center">' . $row['stock'] . '</td>
            <td align="center"><input type="text" name="sale_price[' .
            $row['sku'] . ']" id="sale_price[' . $row['sku'] . ']" class="small"
            /></td>
              <td align="center"><input type="text" name="start_date[' .
            $row['sku'] . ']" id="start_date[' . $row['sku'] . ']"
                class="calendar" /></td>
              <td align="center"><input type="text" name="end_date[' .
            $row['sku'] . ']" id="end_date[' . $row['sku'] . ']" class="calendar"
              /></td>
              </tr>';
        }
        ?>

      </tbody>
    </table>
    <div class="field"><input type="submit" value="Add These Sales" class="button" /></div>
  </fieldset>
</form>
<link href="/css/ui-lightness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/
        jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  $(function() {
    $(".calendar").datepicker({
      dateFormat: "yy-mm-dd",
      minDate: 0
    });
  });
</script>
<?php include('./includes/footer.html'); ?>