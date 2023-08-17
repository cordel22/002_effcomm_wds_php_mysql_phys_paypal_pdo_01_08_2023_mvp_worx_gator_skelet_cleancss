
//  asi odstran duplicitny je

<div class="main">

<!--  box begin -->
<div class="box alt"><div class="left-top-corner"><div class=
  "right-top-corner"><div class="border-top"></div></div></div>
  <div class="border-left"><div class="border-right"><div class="inner">
    <h2>Your Order is Complete</h2>
    <p>
      Thank you for your order (#<?php echo $_SESSION['order_id']; ?>).
      Please use this order number in any corespondence with us.
    </p>
    <p>
      A charge of $<?php echo $_SESSION['order_total']; ?> eill apper
      on your credit card when the order ships. All orders are processed on the 
      next business day. You will be contacted in case of any delays
    </p>
    <p>
      An email confrmation has been sent to your email addess.
      <a href="receipt.php">Click here</a>to crete  printable receipt of
      your order.
    </p>
  </div></div></div><div class="left-bot-corner"><div class=
    "right-bot-corner"><div class="border-bot"></div></div></div>
  </div>
  <!-- box end  -->
  
  
</div>  <!--  main end -->