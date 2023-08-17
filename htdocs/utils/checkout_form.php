





<form action="/checkout.php" method="POST">
    
    <?php include ('./htdocs/includes/form_functions.inc.php'); ?>
    
    <fieldset>
      <div class="field"><label for="use"><strong>Use Same Address
        for Billing?</strong></label><br /><input type="checkbox"
        name="use" value="Y" id="use" <?php if (isset($_POST['use']))
        echo 'checked="checked" ';?>/></div>
    
        <div class="field"><label for="first_name"><strong>First name
          <span class="required">*</span>
        </strong></label><br /><?php
          create_form_input('first_name','text',$shipping_errors);?></div>
        <div class="field">
          <label for="last_name"><strong>Last name
            <span class="required">*</span>
          </strong></label><br />
          <?php
            create_form_input('last_name', 'text', $shipping_errors); 
          ?>
        </div>
        <div class="field">
          <label for="address1"><strong>Street Address
            <span class="required">*</span>
          </strong></label><br />
          <?php
            create_form_input('address1', 'text', $shipping_errors); 
          ?>
        </div>
        <div class="field">
          <label for="address2"><strong>Street Address, Continued, Leave Empty for now
            
          </strong></label><br />
          <?php
            create_form_input('address2', 'text', $shipping_errors); 
          ?>
        </div>
        <div class="field">
          <label for="city"><strong>City
            <span class="required">*</span>
          </strong></label><br />
          <?php
            create_form_input('city', 'text', $shipping_errors); 
          ?>
        </div>
    
        <div class="field">
          <label for="state"><strong>State
            <span class="required">*</span>
          </strong></label><br />
          <?php
          create_form_input('state', 'select', $shipping_errors); 
          ?>
        </div>
    
        <div class="field"><label for="zip"><strong>Zip Code
          <span class="required">*</span>
        </strong></label><br />
          <?php
            create_form_input('zip','text',$shipping_errors);
          ?>
      </div>
      <div class="field">
        <label for="phone"><strong>Phone Number
          <span class="required">*</span>
        </strong></label><br />
        <?php
          create_form_input('phone', 'text', $shipping_errors); 
        ?>
      </div>
      <div class="field">
        <label for="email"><strong>Email Address
          <span class="required">*</span>
        </strong></label><br />
        <?php
          create_form_input('email', 'text', $shipping_errors); 
        ?>
      </div>
      <br clear="all" />
      <div align="center"><input type="submit" value="Continue onto
        Billing" class="button" />
    </fieldset>
    </form>