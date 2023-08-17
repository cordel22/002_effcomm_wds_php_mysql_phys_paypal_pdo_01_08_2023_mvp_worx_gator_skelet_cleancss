

<?php

//  while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
      //  TODO async call to browse.php ..?
        if (!$header) { ?>
    
      
    
      <!--  box begin -->

      <!--  not in css files -->
      <div class="box alt">

        <!--  not in css files  -->
        <div class="left-top-corner">
          <div class="right-top-corner">
            <div class="border-top">

        </div></div></div>
        <!--  end not in css files  -->
        <div class="clearfix" style="border: 1px solid black;"><!--first div  dont delet, is in style.css   -->

        <!--  not in css files  -->
        <div class="border-left">
          <div class="border-right">
            <div class="inner">
              <!--  end not in css files where does it close..? ah, in views/list_coffees.html  -->
              <div class="gallery">   <!--   in style.css -->
                <h2><?php echo $category; ?></h2>
                  <!--  <div class="img-box"> this bitch was extra screwing up the css!!! -->
                    <!--  <p> -->
                      <img width="50" height="50"  alt="<?php echo $category; ?>" src="htdocs/products/<?php
                      echo $row['image']; ?>" />
              </div><!--end class gallery -->
                  <p class="desc">  <!--  added class desc  in styles.css  -->
                    <?php echo $row['description']; ?>
                  </p>
                <!--  </p> -->

                  <p>
                    <small>All listed products are currently available.</small>
                    <form action="/cart.php" method="get">
                      <input type="hidden" name="action" value="add" />
                      <select name="sku">
                        <?php //  The header has now been shown:
                            $header = true;
                          } //  End of $header IF.
                  
                          /*<!-- echo "<option value=\"{$row['sku']}\">{$row['name']}</option>\n";   -->*/
                          echo '<option value="' . $row['sku'] . '">' . $row['name'] . 
                            /*<!--echo '<option value="' . $row['sku'] . ', ' . $row['name'] . -->*/
                            get_price($type,$row['price'],$row['sale_price']) .
                          '</option>';
                        }?>
