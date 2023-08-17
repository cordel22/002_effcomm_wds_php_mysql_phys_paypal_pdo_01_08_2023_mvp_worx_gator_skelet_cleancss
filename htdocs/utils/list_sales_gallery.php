

<?php

//  while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
        echo '
          <div class="clearfix" style="border: 1px solid black;"><!--first div  -->                        
            <div class="gallery">
              <h3 id="' . $row['sku'] . '">' . $row['category'] . '::' . $row['name'] . '<h3>
              <!--  <div class="img-box">   this must go off, in the way of css...  -->
                <!--  <p>   -->
                  <img width="50" height="50"  alt="' . $row['name'] . '" src="/htdocs/products/' . $row['image']
                    . '"/>
                  </div><!--end class gallery -->
                  <p class="desc">  <!--  added class desc    -->
                    ' . $row['description'] . '
                  </p>
                    <br />
                  <p class="desc">' .
                    get_price('goodies', $row['price'], $row['sale_price']) . '
                    <strong>Availability:</strong>'
                    . get_stock_status($row['stock']) . '
                  </p>
                  <p class="desc">
                    <button class="btn btn-header">
                      <a href="/cart.php?sku=' . $row['sku'] . '&action=add" class="button">Add to Cart</a>
                    </button>
                  </p>
              </div>
            </div>  <!--  end of clearfix ...   -->
          ';
      }