



<?php



session_start();
$uid = session_id();

if (!isset($_SESSION['customer_id'])) {
  $location = 'https://' . BASE_URL . 'checkout.php';
  header("Location: $location");
  exit();
}