<?php

//  select if connecting to DB from server or hostgator!!!
//  dont forget to setup htdocs/includes/config.php

/*  server DB connection: 
//  Set the database access information as constants:
DEFINE('DB_USER', 'vladkome_cordel');
DEFINE('DB_PASSWORD', 'DoPsejMatere123!');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'vladkome_002_effcomm_php_mysql_phys_paypal_online');

try {
  $pdo = new PDO("mysql:host=localhost;dbname=vladkome_002_effcomm_php_mysql_phys_paypal_online; charset=utf8mb4", DB_USER, DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

 end of hostgator server DB connection   */


//  Set the database access information as constants:
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'ecommerce2');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ecommerce2; charset=utf8mb4", DB_USER, DB_PASSWORD);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  next line displays all over the site to see if connected to db
    //  echo "Connected successfully ma niggaz";
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/*  end localhost connection	*/


//  Omit the closing PHP tag to avoid 'headers already sent' error!


