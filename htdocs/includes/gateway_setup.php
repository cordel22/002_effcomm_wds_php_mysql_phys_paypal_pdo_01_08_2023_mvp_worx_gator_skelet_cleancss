
<?php
//  Create an array for the information:
$data = array();

//  Transaction type:
$data['x_type'] = 'AUTH_ONLY';

//  Billing info:
$data['x_card_num'] = $cc_number;
$data['x_exp_date'] = $cc_exp;
$data['x_card_code'] = $cc_cvv;
$data['x_first_name'] = $cc_first_name;
$data['x_last_name'] = $cc_last_name;
//  debuging
//  $data['x_address'] = $cc_address;
//  debuging
$data['x_state'] = $cc_state;
$data['x_city'] = $cc_city;
$data['x_zip'] = $cc_zip;

/* Because the payment-processing scripts will contain sensitive information (the
next one will especially), I recommend storing it outside the Web root directory,
if at all possible. If not, place gateway_setup.php in the includes directory, but
prevent that directory from being accessible over the Internet. See Chapter 7
for instructions. */

?>



