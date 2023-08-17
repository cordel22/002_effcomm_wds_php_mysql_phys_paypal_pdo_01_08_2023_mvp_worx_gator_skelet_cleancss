<?php
if ($live) {
  define('GATEWAY_API_URL', 'https://secure.authorize.net/gateway/transact.dll');
} else {
  define('GATEWAY_API_URL', 'https://test.authorize.net/gateway/transact.dll');
}

$data['x_login'] = '75sqQ96qHEP8';
$data['x_tran_key'] = '7r83Sb4HUd58TZ5p';

/* 
These two pieces of information uniquely identify you to the Authorize.net
system. You should use the values emailed to you by Authorize.net in
your code.

 */

$data['x_version'] = '3.1';
$data['x_delim_data'] = 'TRUE';
$data['x_delim_char'] = '|';
$data['x_relay_response'] = 'FALSE';

$data['x_method'] = 'CC';

$data['x_amount'] = $order_total;
$data['x_invoice_num'] =  $order_id;
$data['x_cust_id'] = $customer_id;

$post_string = '';
foreach ($data as $k => $v) {
  $post_string .= "$k=" . urlencode($v) . "&";
}
$post_string = rtrim($post_string, '&');

$request = curl_init(GATEWAY_API_URL);
curl_setopt($request, CURLOPT_HEADER, 0);
curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);

$response = curl_exec($request);
curl_close($request);
//  debugging
$post_response = 'Approved';
$response_array = explode($data["x_delim_char"], $post_response);
//  debugging