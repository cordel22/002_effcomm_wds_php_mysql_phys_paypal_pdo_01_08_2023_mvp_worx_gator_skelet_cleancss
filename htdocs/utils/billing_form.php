


<form action="/billing.php" method="POST">
<?php
  include ('./htdocs/includes/form_functions.inc.php');
?>
<div class="field"><label for="cc_number"><strong>Card Number, like 4242 4242 4242 4242 without spaces

</strong></label><br /><?php create_form_input('cc_number',
  'text',$billing_errors,'POST','autocomplete="off"');
  ?>
</div>
<div class="field"><label for="exp_date"><strong>Expiration Date

</strong></label><br /><?php create_form_input('cc_exp_month',
  'select',$billing_errors);
  ?>
  <?php create_form_input('cc_exp_year',
  'select',$billing_errors);
  ?>
</div>
<div class="field"><label for="cc_cvv"><strong>CVV

</strong></label><br /><?php create_form_input('cc_cvv',
  'text',$billing_errors,'POST','autocomplete="off"');
  ?>
</div>
<fieldset>
  <div class="field"><label for="cc_first_name"><strong>First Name

  </strong></label><br /><?php create_form_input('cc_first_name',
    'text',$billing_errors, $values);
    ?>
  </div>
  <div class="field"><label for="cc_last_name"><strong>Last Name

  </strong></label><br /><?php create_form_input('cc_last_name',
    'text',$billing_errors, $values);
    ?>
  </div>
  <div class="field"><label for="address"><strong>Street Address

  </strong></label><br /><?php create_form_input('cc_address',
    'text',$billing_errors,$values);
    ?>
  </div>
  <div class="field"><label for="city"><strong>City

  </strong></label><br /><?php create_form_input('cc_city',
    'text',$billing_errors,$values);
    ?>
  </div>
  <div class="field"><label for="state"><strong>State
  </strong></label><br /><?php create_form_input('cc_state',
    'select',$billing_errors,$values);
    ?>
  </div>
  <div class="field"><label for="zip"><strong>Zip Code

  </strong></label><br /><?php create_form_input('cc_zip',
    'text',$billing_errors,$values);
    ?>
  </div>
  <br clear="all" />
  <div align="center"><input type="submit" value="Place Order"
    class="button" /></div>
</fieldset>
</form>