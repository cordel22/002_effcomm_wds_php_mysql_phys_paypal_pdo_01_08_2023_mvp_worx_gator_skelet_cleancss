
<?php
//  Set the database access information as constants:
DEFINE('DB_USER', 'vladkome_cordel');
DEFINE('DB_PASSWORD', 'DoPsejMatere123!');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'vladkome_002_effcomm_php_mysql_phys_paypal_online');

// //    error reporting
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// //  Make the connection:
// $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// //  Set the character set:

// mysqli_set_charset($dbc, 'utf8');


try {
  /* 
  echo "
<pre>\n"; */

  $pdo = new PDO("mysql:host=localhost;dbname=vladkome_002_effcomm_php_mysql_phys_paypal_online; charset=utf8mb4", DB_USER, DB_PASSWORD);

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //    debug
  //    echo "Connected successfully";
  //    debug
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}



//  for more typess of users:
/* 
$user = 'general';
require(MYSQL);

DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'ecommerce2');
if (isset($user) && ('user' == 'general') ) {
  DEFINE('DB_USER', 'username');
  DEFINE('DB_PASSWORD', 'password');
} elseif (isset($user) && ('user' == 'cart')) { //...
  DEFINE('DB_USER', 'otherUser');
  DEFINE('DB_PASSWORD','otherPassword');
}
 */



//  Omit the closing PHP tag to avoid 'headers already sent' error!
