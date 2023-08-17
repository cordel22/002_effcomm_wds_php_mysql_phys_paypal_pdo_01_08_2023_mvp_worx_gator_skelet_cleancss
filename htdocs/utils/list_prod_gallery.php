

<?php


    //  while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC)) {
    
    //  TODO async call to browse.php ..?
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
            if (!$header) {?>
            
              <!--  box begin     moze ist v <>   -->
              <!--  <div class="box alt"> -->
                  <!--
                  <div class="left-top-corner">
                      <div class="right-top-corner">
                          <div class="border-top">
                              
                          </div></div></div>  -->
                <!--    <div class="border-left"> -->
                    
                  <!--  <div class="border-right">
                  <div class="inner">       moze ist v <>     -->
                    
                    <h2><?php echo $category; ?></h2>
                    <div class="img-box">   <!--    dont delete, u need the pic but img-box class not in css files   -->
                      <p><img width="50" height="50"  alt="<?php echo $category; ?>" src="htdocs/products/<?php
                        echo $row['g_image']; ?>" /><?php echo $row['g_description'];
                      ?>
                      </p>
                    </div>                <!--    end img-box div  -->
                    
                  <!--    </div></div>       moze ist v <>    -->
                  <!--    
                  <div class="left-bot-corner">
                      <div class="right-bot-corner">
                          <div class="border-bot">
                              
                          </div></div><div>
                              -->
                  <!--        </div><!--    end of class="border-left"> -->
                  <!--  </div> -->  <!--  box end      moze ist v <>    -->
                  
                  <p><br clear="all" /></p>
      
                  <!--  box begin -->
                  <div class="box">                  <!--    u put it there or irs from the book..?    -->
                      
                      <!--         moze ist v <>   
                      <div class="left-top-corner">
                          <div class="right-top-corner"><div class="border-top">
                              
                          </div></div></div>
                           moze ist v <>       -->

                  <!--    not in css    where do they end..?    -->
                  <div class="border-left">
                      <div class="border-right">
                          <div class="inner">
                  <!--    not in css    -->
                  <?php
                    $header = true;
                  } //  End of $header IF.
                
                  echo '
                  <div class="clearfix" style="border: 1px solid black;"><!--first div, clearfix in style.css  -->
                    <div class="gallery"> <!--  gallery in style.css  -->
                      <h3>' . $row['name'] . '</h3>
                      <!--  <div class="img-box">   this div ws in the way!!!        moze ist v <>   -->
                        <!--  <p>          moze ist v <>    -->
                          
                      <img width="50" height="50"  alt="' . $row['name'] . '" src="htdocs/products/' . $row['image']
                          . '" />
                    </div><!--end class gallery -->
                      <p class="desc">          <!--  added class desc   in style.css  -->
                          ' . $row['description'] . '<br />' .
                          
                          get_price($type,$row['price'],$row['sale_price']) .   '<!--  get_price, not get_SALE_price!!! -->' .
                          '<strong>Availability:</strong>' . get_stock_status($row['stock']) . '<!--  p 218 ' . $row['stock'] . ' -->
                      </p>        <!--  end class desc   in style.css  -->
                      <p class="desc">      <!--  added class desc   in style.css  -->
                        <button class="btn btn-header">
                          <a href="/cart.php?sku=' . $row['sku'] . '&action=add"
                              class="button">Add to Cart
                          </a>
                        </button>
                      </p>        <!--  end added class desc   in style.css  -->
                  </div>      <!--  or this is end first div..?  -->
                </div>  <!--  end first div or possibly the inner..?  -->
                  ';
      
          /*  <!-- <h3>Red Dragon Mug</h3>         moze ist v <>   
            //    ???
            <strong>Price:</strong>$' . $row['price'] . '<br /> 
      
            get_sale_price($type,$row['price'],$row['sale_price']) . 
            //    ???
          <div class="img-box">
            <p><img width="50" height="50"  alt="red Dragon Mug" src="htdocs/products/imagename.ext" />
              Actual Description<br />
            <strong>Price:</strong>$4.50<br /> <strong>Availability:</strong>
              67
            </p>
            <p><a href="/cart.php?sku=O23&action=add" class="button">
              Add to Cart
            </a></p>
          </div> -->         moze ist v <>      */
          }