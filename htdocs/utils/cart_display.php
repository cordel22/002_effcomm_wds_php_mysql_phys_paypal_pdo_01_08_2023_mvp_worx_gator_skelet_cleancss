



<?php

echo '<div class="cart_display">';

//  while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        $price = get_just_price($row['price'],$row['sale_price']);
        $subtotal = $price * $row['quantity'];
        echo '<tr>
          <td>' . $row['category'] . '::' . $row['name'] . '</td>
          <td align="center"><input type="text" name="quantity[' .
            $row['sku'] . ']"value="' . $row['quantity'] . '"size="2" /></td>
          <td align="right">$' . $price . '</td>
          <td align="right">$' . number_format($subtotal,2) . '</td>
          <td align="right">
            <br />
            <button class="btn btn-header">
              <a href="/cart.php?sku=' . $row['sku'] . '&action=remove">
                Remove from Cart
              </a>
            </button>  
          </td>
          </tr>
          ';
          
        if ($row['stock'] < $row['quantity']) {
          echo '<tr class="error"><td colspan="5" align="center">There are
            only' . $row['stock'] . 'left in stock of the' . $row['name'] . '.Please
            update the quantity, remove the item entirely, or move it to your
            wish list.</td></tr>';
        }
        //  page  248 bottom
        
        $total += $subtotal;
        $shipping = get_shipping($total);
        $total += $shipping;
        echo '<tr>
          <td colspan="3" align="right"><strong>Shipping &amp; handling
  
          </strong></td>
          <td align="right">$' . $shipping . '</td>
          <td>&nbsp;</td>
        </tr>
        ';
      } //  End of WHILE loop.

      echo '</div>';  //  doesn really run yet


      