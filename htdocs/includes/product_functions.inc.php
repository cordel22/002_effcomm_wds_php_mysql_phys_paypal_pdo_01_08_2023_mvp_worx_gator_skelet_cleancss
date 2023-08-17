
<?php
function get_stock_status($stock)
{
  if ($stock > 5) {
    return 'In Stock';
  } elseif ($stock >= 1) {
    return 'Low Stock';
  } else {
    return 'Currently Out of Stock';
  }
}   //  End of get_stock_status() function

function get_price($type, $regular, $sales)
{
  if ($type == 'coffee') {
    if ((0 < $sales) && ($sales < $regular)) {
      return 'Sale:$' . $sales . '!';
    }
  } elseif ($type == 'goodies') {
    if ((0 < $sales) && ($sales < $regular)) {
      return "<strong>Sale Price:</strong>\$$sales!(normally
      \$$regular)<br />";
    } else {
      return '<strong>Price:</strong>$' . $regular . '<br />';
    }
  }
}   //  End of get_price() function.

function get_just_price($regular, $sales)
{
  if ((0 < $sales) && ($sales < $regular)) {
    return number_format($sales, 2);
  } else {
    return number_format($regular, 2);
  }
}

function parse_sku($sku)
{
  //  Grab the first character:
  $type_abbr = substr($sku, 0, 1);

  //  Grab the remaining chrcter:
  $pid = substr($sku, 1);

  //  Validate the type:
  if ($type_abbr == 'C') {
    $sp_type = 'coffee';
  } elseif ($type_abbr == 'O') {
    $sp_type = 'other';
  } else {
    $sp_type = NULL;
  }

  //  Validate the product ID:
  $pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1))) ? $pid : NULL;

  //  Return the values:
  return array($sp_type, $pid);
} //  End of parse_sku() function.

/* 
Finally, both values are returned as an array. Because this function returns an
array, you must use the list( ) function when calling it:
list($type, $id) = parse_sku($sku);
 */

function get_shipping($total = 0)
{
  //  Set the base handling charges:
  $shipping = 3;
  //  Rate is based upon the total:
  if ($total < 10) {
    $rate = .25;
  } elseif ($total < 20) {
    $rate = .20;
  } elseif ($total < 50) {
    $rate = .18;
  } elseif ($total < 100) {
    $rate = .16;
  } else {
    $rate = .15;
  }
  //  Calculate the shipping total:
  $shipping = $shipping + ($total * $rate);
  //  Return the shipping total:
  return number_format($shipping, 2);
}   //  End of get_shipping() function




?>
