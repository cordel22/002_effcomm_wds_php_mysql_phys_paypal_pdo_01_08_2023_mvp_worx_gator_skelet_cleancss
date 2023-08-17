



<?php

//  nefunguje, vratil si na miesto...!!!


//  page  288 / 305
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* if (get_magic_quotes_gpc()) {
      $_POST['cc_first_name'] = stripslashes($_POST['cc_first_name']);
      //  Repeat for other variables that could be affected.
    } */
    if (preg_match('/^[A-Z\'.-]{2,20}$/i', $_POST['cc_first_name'])) {
      $cc_first_name = $_POST['cc_first_name'];
    } else {
      $billing_errors['cc_first_name'] = 'Please enter your first name!';
    }
    if (preg_match('/^[A-Z\'.-]{2,40}$/i', $_POST['cc_last_name'])) {
      $cc_last_name = $_POST['cc_last_name'];
    } else {
      $billing_errors['cc_last_name'] = 'Please enter your last name!';
    }
    $cc_number = str_replace(array('', '-'), '', $_POST['cc_number']); //  missing quotes in the book
  
    if (
      !preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cc_number) //  Visa
      &&  !preg_match('/^5[1-5][0-9]{14}$/', $cc_number) //  MasterCard
      &&  !preg_match('/^3[47][0-9]{13}$/', $cc_number)  //  American Express
      &&  !preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $cc_number) //  Discover
    ) {
      $billing_errors['cc_number'] = 'Please enter your credit card number!';
    }
    if (($_POST['cc_exp_month'] < 1 || $_POST['cc_exp_month'] > 12)) {
      $billing_errors['cc_exp_month'] = 'Please enter your expiration month!';
    }
    if ($_POST['cc_exp_year'] < date('Y')) {
      $billing_errors['cc_exp_year'] = 'Please enter your expiration year!';
    }
    if (preg_match('/^[0-9]{3,4}$/', $_POST['cc_cvv'])) {
      $cc_cvv = $_POST['cc_cvv'];
    } else {
      $billing_errors['cc_cvv'] = 'Please enter your CVV!';
    }
    if (preg_match('/^[A-Z0-9\',#-]{2,160}$/i', $_POST['cc_address'])) {
      $cc_address = $_POST['cc_address'];
    } else {
      $shipping_errors['cc_address'] = 'Plese enter your street address!';
    }
    //  debug
    /* if (preg_match('/^[A-Z\'.-]{2,60}$/i', $_POST['cc_city'])) { */
    $cc_city = $_POST['cc_city'];
    /* } else {
      $billing_errors['cc_city'] = 'Please enter your city!';
    } */
    //  koniec debugu
    if (preg_match('/^[A-Z]{2}$/', $_POST['cc_state'])) {
      $cc_state = $_POST['cc_state'];
    } else {
      $billing_errors['cc_state'] = 'Please enter your state!';
    }
    if (preg_match('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['cc_zip'])) {
      $cc_zip = $_POST['cc_zip'];
    } else {
      $billing_errors['cc_zip'] = 'Please enter your zip code!';
    }
  
    if (empty($billing_errors)) {
      $cc_exp = sprintf(
        '%02d%d',
        $_POST['cc_exp_month'],
        $_POST['cc_exp_year']
      );
      if (isset($_SESSION['order_id'])) {
        $order_id = $_SESSION['order_id'];
        $order_total = $_SESSION['order_total'];
      } else {  //  Create a new order record:
        $cc_last_four = substr($cc_number, -4);
        /* $r = mysqli_query($dbc, "CALL add_order({$_SESSION['customer_id']},
        '$uid', {$_SESSION['shipping']},$cc_last_four, @total, @oid)"); */
        //  replace stored procedures with prepared statements
        //  $r = $pdo->query("CALL add_order({$_SESSION['customer_id']},
        //  '$uid', {$_SESSION['shipping']},$cc_last_four, @total, @oid)");
        
        //  add_order without stored procedures
        $r = $pdo->prepare($add_order);
        $r->execute(array(
          ':cid' => $_SESSION['customer_id'],
          ':ship' => $_SESSION['shipping'],
          ':cc' => $cc_last_four,
        ));
  
        $whats_oid = $pdo->prepare($out_oid);
        /*$oid = */$whats_oid->execute(array(
        
        ));
        $assoc = $whats_oid->fetch(PDO::FETCH_ASSOC);
        $oid = (int) $assoc['LAST_INSERT_ID()'];
  
        $r = $pdo->prepare($add_order_continues);
        $r->execute(array(
          ':uid' => $uid,
          ':oid' => $oid,
        ));
  
        $whats_subtotal = $pdo->prepare($out_subtotal);
        /*$subtotal = */$whats_subtotal->execute(array(
          ':oid' => $oid,
        ));
        $assoc = $whats_subtotal->fetch(PDO::FETCH_ASSOC);
        //  debug
        /*
        echo '<br />';
        echo '$assoc = ';
        var_dump($assoc);
        echo '<br />';
        //  end debug
        */
        $subtotal = (int) $assoc["SUM(quantity*price_per)"];
  
  
        $r = $pdo->prepare($update_order);
        $r->execute(array(
          ':subtotal' => $subtotal,
          ':ship' => $_SESSION['shipping'],
          ':oid' => $oid,
        ));
  
        $total = $subtotal + $_SESSION['shipping'];
  
        //  end add_order
        
        if ($r) {   //  $r is different here to the book!
          //  $r = mysqli_query($dbc, 'SELECT @total, @oid');
          //  replace stored procedures with prepared statements
          //  here we have total and oid extracted since long
          //  $r = $pdo->query('SELECT @total, @oid');
  
          $row_count = $r->rowCount();
  
          //  if (mysqli_num_rows($r) == 1) {
          if ($row_count >= 1) {
            //  from paypal code
            echo '
            <!-- Replace "test" with your own sandbox Business account app client ID -->
            <script src="https://www.paypal.com/sdk/js?client-id=AfuM2OgBgFKKlCuvI2VN4fsMlFaJLdlzCLImv13vTd0TksQEh6j9P2yljbg0cMZ1-4Jjvd7J1t-ysBpS&currency=USD"></script>
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>
            <script>
              paypal.Buttons({
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                  return actions.order.create({
                    purchase_units: [{
                      amount: {
                        value: "$order_total" // Can also reference a variable or function
                      }
                    }]
                  });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                  return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    console.log("Capture result", orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // const element = document.getElementById("paypal-button-container");
                    // element.innerHTML = "<h3>Thank you for your payment!</h3>";
                    // Or go to another URL:  actions.redirect("thank_you.html");
                  });
                }
              }).render("#paypal-button-container");
            </script>
            ';
            //  down to here the paypal code
            //  inak toto co je..?
            //  list($order_total, $order_id) = mysqli_fetch_array($r);
            //  just change the oid to $order_id
            //  list($order_total, $order_id) = $r->fetch(/* PDO::FETCH_ASSOC */);
            $order_total = $total;
            $order_id = $oid;
            //  Process the payment!
            $_SESSION['order_total'] = $order_total;
            $_SESSION['order_id'] = $order_id;
          } else {  //  Could not retrieve the order ID and total.
            unset($cc_number, $cc_cvv);
            trigger_error('Your order could not be processed due to a system
            error. We apologize for the inconvenience.');
          }
        } else {  //  The add_order() procedure failed.
          unset($cc_number, $cc_cvv);
          trigger_error('Your order could not be processed due to a system
          error. We apologize for the inconvenience.');
        }
      } //  End of isset($_SESSION['order_id']) IF-ELSE.
  
      //  p 300 / 317
      //  authorize.net card gateway
      
      if (isset($order_id, $order_total)) {
        $customer_id = $_SESSION['customer_id'];
        
        require_once(BASE_URI . '/htdocs/includes/gateway_setup.php');
        require_once(BASE_URI . '/htdocs/includes/gateway_process.php');
        /* 
        $reason = addslashes($response_array[3]);
        $response = addslashes($response);
  
        $r = mysqli_query($dbc, "CALL add_transaction($order_id,
        '{$data['x_type']}',$response_array[9],$response_array[0],'$reason',
        $response_array[6],'$response')");
         */
        //  as we dont really connect to authorize.net...
        //  if ($response_array[0] == 1) {
        if (true) {
          //  $_SESSION['response_code'] = $response_array[0];
          //  no matter what payment gets thru!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
          $_SESSION['response_code'] = '1';
          
          //  in gator BASE_URL is superfluous
          $location = /*'https://' . */BASE_URL . 'final.php';
          $location = /*'https://' . BASE_URL . */'final.php';
          
          header("Location: $location");
          exit();
        } else {
          if ($response_array[0] == 2) {  //  Declined
            $message = $response_array[3] . 'Please fix the error or try nother
            card.';
          } elseif ($response_array[0] == 3) {  //  Error
            $message = $response_array[3] . 'Please fix the error or try
            another card.';
          } elseif ($response_array[0] == 4) {  //  Held for review
            $message = "The transaction is being held for review. You
            will be contacted ASAP about your order. We apologize for any 
            inconvenience.";
          }
        }
      }   //  End of isset($order_id,$order_total) IF
  
      //  end of authorize.net card gateway
  
    }   //  Errors occurred IF.
  }   //  End of REQUEST_METHOD IF.