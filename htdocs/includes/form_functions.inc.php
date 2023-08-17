<?php

function create_form_input($name, $type, $errors, $values = 'POST', $extras = '')
{
  $value = false;
  if ($values == 'SESSION') {
    if (isset($_SESSION[$name])) $value = $_SESSION[$name];
  } elseif ($values == 'POST') {
    if (isset($_POST[$name])) $value = $_POST[$name];
    //  debug magic quotes
    /* if ($value && get_magic_quotes_gpc()) $value = stripslashes($value); */
  }

  if (($type == 'text') || ($type == 'password')) {
    echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '"';
    if ($value) echo 'value="' . htmlspecialchars($value) . '"';
    if (!empty($extras)) echo "$extras";
    if (array_key_exists($name, $errors)) {
      echo 'class="error" /><br /><span class="error">' . $errors[$name] . '</span>';
    } else {
      echo '/>';
    }
  } elseif ($type == 'select') {
    if (($name == 'state') || ($name == 'cc_state')) {
      $data = array(
        'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona',
        'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' =>
        'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' =>
        'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN'
        => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky',
        'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA'
        => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS'
        => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' =>
        'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' =>
        'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' =>
        'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' =>
        'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' =>
        'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota',
        'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' =>
        'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West
        Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'
      );
    } elseif ($name == 'cc_exp_month') {
      $data = array(
        1 => 'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      );
    } elseif ($name == 'cc_exp_year') {
      $data = array();
      $start = date('Y');
      for ($i = $start; $i <= $start + 5; $i++) {
        $data[$i] = $i;
      }
    } //  End of $name IF-ELSEIF.
    echo '<select name="' . $name . '"';
    if (array_key_exists($name, $errors)) echo ' class="error"';
    echo '>';

    foreach ($data as $k => $v) {
      echo "<option value=\"$k\"";
      if ($value == $k) echo ' selected="selected"';
      echo ">$v</option>\n";
    } //  End of FOREACH.
    echo '</select>';

    if (array_key_exists($name, $errors)) {
      echo '<br /><span class="error">' . $errors[$name] . '</span>';
    }
    //  p 316 / 333
  } elseif ($type == 'textarea') {
    //  Display the error first:
    if (array_key_exists($name, $errors)) echo '<span class="error">'
      . $errors[$name] . '</span>';
    //  Start creating the textarea:
    echo '<textarea name="' . $name . '" id="' . $name . '" rows="5" cols="75"';
    //  Add the error class, if pplicble:
    if (array_key_exists($name, $errors)) {
      echo 'class="error">';
    } else {
      echo '>';
    }
    //  Add the value to the textarea:
    if ($value) echo $value;
    //  Complete the textarea:
    echo '</textarea>';
    // asi ten bug  }
  } //  End of primary IF-ELSE.
}   //  End of the create_form_input() function.
