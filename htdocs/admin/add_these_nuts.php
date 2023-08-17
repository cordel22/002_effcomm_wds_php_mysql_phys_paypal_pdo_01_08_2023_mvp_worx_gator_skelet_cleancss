<?php
require('../includes/config.php');    //  je tos pravne..?
$page_title = 'Add a Goodie';
include('./includes/header.html');
require(MYSQL);

$add_product_errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_POST['category']) || !filter_var(
    $_POST['category'],
    FILTER_VALIDATE_INT,
    array('min_range' => 1)
  )) {
    $add_product_errors['category'] = 'Please select a category!';
  }
  if (empty($_POST['price']) || !filter_var(
    $_POST['price'],
    FILTER_VALIDATE_FLOAT
  ) || ($_POST['price'] <= 0)) {
    $add_product_errors['price'] = 'Please enter a valid price!';
  }
  if (empty($_POST['stock']) || !filter_var(
    $_POST['stock'],
    FILTER_VALIDATE_INT,
    array('min_range' => 1)
  )) {
    $add_product_errors['stock'] = 'Please enter the quantity in stock!';
  }
  if (empty($_POST['name'])) {
    $add_product_errors['name'] = 'Please enter the name!';
  }
  if (empty($_POST['description'])) {
    $add_product_errors['description'] = 'Please enter the description!';
  }

  if (
    is_uploaded_file($_FILES['image']['tmp_name']) &&
    ($_FILES['image']['error'] == UPLOAD_ERR_OK)
  ) {     //  de konci..?
    $file = $_FILES['image'];
    $size = ROUND($file['size'] / 1024);
    if ($size > 512) {
      $add_product_errors['image'] = 'The uploded file was too large!';
    }
    $allowed_mime = array(
      'image/gif', 'image/pjpeg', 'image/jpeg',
      'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png'
    );
    $allowed_extensions = array('.jpg', '.gif', '.png', 'jpeg');
    $image_info = getimagesize($file['tmp_name']);
    $ext = substr($file['name'], -4);
    if ((!in_array($file['type'], $allowed_mime))
      || (!in_array($image_info['mime'], $allowed_mime))
      || (!in_array($ext, $allowed_extensions))
    ) {
      $add_product_errors['image'] = 'The uploaded file was not of the proper type.';
    }
    if (!array_key_exists('image', $add_product_errors)) {
      $new_name = (string) sha1($file['name'] . uniqid('', true));
      $new_name .= ((substr($ext, 0, 1) != '.') ? ".{$ext}" : $ext);
      $dest = "../products/$new_name";
      if (move_uploaded_file($file['tmp_name'], $dest)) {
        $_SESSION['image']['new_name'] = $new_name;
        $_SESSION['image']['file_name'] = $file['name'];
        echo '<h4>The file has been uploaded!</h4>';
      } else {
        trigger_error('The file could not be moved.');
        unlink($file['tmp_name']);
      }
    } //  End of array_key_exists() IF.
  } elseif (!isset($_SESSION['image'])) {
    switch ($_FILES['image']['error']) {
      case 1:
      case 2:
        $add_product_errors['image'] = 'The uploaded file was too large.';
        break;
      case 3:
        $add_product_errors['image'] = 'The file was only partially uploaded.';
        break;
      case 6:
      case 7:
      case 8:
        $add_product_errors['image'] = 'The file could not be uploaded due to a system error.';
        break;
      case 4:
      default:
        $add_product_errors['image'] = 'No file was uploaded.';
        break;
    } //  End of SWITCH.
  }   //  End of $_FILES IF-ELSEIF-ELSE.

  $name = $_POST['name'];
  $desc = $_POST['description'];

  $price = $_POST['price'];
  $stock = $_POST['stock'];
  //  debug

  echo '<br />  config je tu? ' . $config;
  echo '<br /> POST category  =' . $_POST['category'];
  echo '<br /> POST name  =' . $_POST['name'];
  echo '<br /> name  =   ' . $name;
  echo '<br /> POST description  =' . $_POST['description'];
  echo '<br />  desc =  ' . $desc;
  echo '<br />  Session[image][new_...] ' . $_SESSION['image']['new_name'];
  echo '<br />  POST[price] ' . $_POST['price'];
  echo '<br />  POST[stock] ' . $_POST['stock'];
  //  end debug

  if (empty($add_product_errors)) {
    $q = 'INSERT INTO non_coffee_products (non_coffee_category_id,
    name,description,image,price,stock) VALUES (?,?,?,?,?,?)';
    $stmt = mysqli_prepare($dbc, $q);
    mysqli_stmt_bind_param(
      $stmt,
      'isssdi',
      $_POST['category'],
      $name,
      $desc,
      $_SESSION['image']['new_name'],
      $price,
      $stock
      /* $_POST['price'],
      $_POST['stock'] */
    );
    $name = strip_tags($_POST['name']);
    $desc = strip_tags($_POST['description']);
    mysqli_stmt_execute($stmt);
    //  toto asi do <>  ne? }

    //  p 321 / 338

    if (mysqli_stmt_affected_rows($stmt) == 1) {
      echo '<h4>The product hs been added!</h4>';
      $_POST = array();
      $_FILES = array();
      unset($file, $_SESSION['image']);
    } else {
      trigger_error('The product could not be added due to a system error.
    We apologize for any inconvenience');
      unlink($dest);
    }
  } //  End of $errors IF.

} else {  //  Clear out the session on a GET request:
  unset($_SESSION['image']);
} //  End of the sumission IF.

require('../includes/form_functions.inc.php');
?>

<h3>Add Non-Coffee Product (a "Goodie")</h3>
<form enctype="multipart/form-data" action="add_these_nuts.php" method="post" accept-charset="utf-8">
  <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
  <fieldset>
    <legend>Fill out the form to add-non-coffee product to
      the catalog. All fields are required.</legend>
    <div class="field"><label for="category"><strong>Category
        </strong></label><br /><select name="category" <?php
                                                        if (array_key_exists('category', $add_product_errors)) echo '
    class="error"'; ?>>
        <option>Select One</option>
        <?php
        $q = 'SELECT id, category FROM non_coffee_categories ORDER BY category ASC';
        $r = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
          echo "<option value=\"$row[0]\"";
          if (isset($_POST['category']) && ($_POST['category'] == $row[0]))
            echo 'selected="selected"';
          echo ">$row[1]</option>\n";
        }
        ?>
      </select><?php
                if (array_key_exists(
                  'category',
                  $add_product_errors
                )) echo ' <span class="error">'
                  . $add_product_errors['category'] . '</span>';
                ?></div>
    <div class="field"><label for="name"><strong>Name</strong>
      </label><br /><?php
                    create_form_input('name', 'text', $add_product_errors);
                    ?></div>
    <div class="field"><label for="price"><strong>Price</strong>
      </label><br /><?php
                    create_form_input('price', 'text', $add_product_errors);
                    ?><small>Without the dollar sign.</small></div>
    <div class="field"><label for="stock"><strong>Initial Quantity in Stock</strong>
      </label><br /><?php
                    create_form_input('stock', 'text', $add_product_errors);
                    ?></div>

    <div class="field"><label for="description"><strong>Description</strong>
      </label><br /><?php
                    create_form_input('description', 'text', $add_product_errors);
                    ?></div>

    <div class="field"><label for="imge"><strong>Image</strong>
      </label><br /><?php
                    if (array_key_exists('image', $add_product_errors)) {
                      echo '<span class="error">' . $add_product_errors['image']
                        . '</span><br /><input type="file" name="image" class="error" />';
                    } else {
                      echo '<input type="file" name="image" />';
                      if (isset($_SESSION['image'])) {
                        echo "<br />Currently'{$_SESSION['image']['file_name']}'";
                      }
                    } // end of errors IF-ELSE.

                    ?></div>

    <br clear="all" />
    <div class="field"><input type="submit" value="Add This Product" class="button" /></div>
  </fieldset>
</form>

<?php include('./includes/footer.html'); ?>