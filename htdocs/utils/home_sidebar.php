

<?php


$row_count = $r->rowCount();
                      
//  if (mysqli_num_rows($r) >= 1) {
if ($row_count >= 1) {
  echo '
    <dl class="special fright">   <!--  special fright not in css files    -->
      <div>
        <dt>
          <a href="/sales.php">Sale Items</a>
        </dt>
    </div>';

  //  while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
  while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
    //  TODO async call to sales.php ..?
    echo '
    <dd>
      <div class="sale_items_home">    <!--  sale_items_home in style.css    -->
        <a href="/sales.php/#' . $row['sku'] . '" title="View this
        Product">
          <img width="50" height="50" alt="" src="htdocs/products/' . $row['image'] . '" /></a>
          <span>'. 
            "     only " . '<a href="/sales.php/#' . $row['sku'] . '" title="View this
          Product">' . $row['sale_price'] .  '</a>'
          . '</span>
        
      </div>        <!--  end div class sale_items_home in style.css    -->
    </dd>';
    }

  echo '</dl>';
}   //  End of mysqli_num_rows() IF.