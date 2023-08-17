

<?php


                //  while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
                    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
                        if ($row['stock'] < $row['quantity']) {
                          echo '<tr class="error"><td colspan="4" align="center">There are
                            only' . $row['stock'] . 'left in stock of the ' . $row['name'] . ' . This
                            item has been removed from your cart and placed in your wish list.
                            </td></tr>';
                          $remove[$row['sku']] = $row['quantity'];
                        } else {
                          $price = get_just_price($row['price'],$row['sale_price']);
                          $subtotal = $price * $row['quantity'];
                          echo '<tr><td>' . $row['category'] . '::' . $row['name'] . '</td>
                            <td align="center">' . $row['quantity'] . '</td>
                            <td align="right">$' . $price . '</td>
                            <td align="right">$' . number_format($subtotal,2) . '</td>
                          </tr>
                          ';
                          $total += $subtotal;
                        }
                      } //  End of WHILE loop.