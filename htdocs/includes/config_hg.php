<?php
//  proper congig, read here:
//  setup the routing for server or localhost here:
//  dont foget to connect the right database in PDO file!!!
//  end of instruction, now do it!

//  Are we live?
$live = false;

//  Errors are emailed here:
$contact_email = 'cordelfenevall@gmail.com';

//  Determine location of files and the URL of the site:

//  define('BASE_URI', 'C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_09_03_2023_mvp_worx_gator_drill');
define('BASE_URI', '/home3/vladkomeciar/ecomm2.siskotrade.com');

//  define('BASE_URL', 'http://localhost:3000/'/*'localhost:3000/' 'www.example.com/' */);
define('BASE_URL', 'www.ecomm2.siskotrade.com/');


//  define('MYSQL', 'C:\wamp\www\002_effcomm_php_mysql_phys_paypal_pdo_09_03_2023_mvp_worx_gator_drill\pdo.php');
define('MYSQL', '/home3/vladkomeciar/ecomm2.siskotrade.com/pdo.php'/* '/path/to/mysql.inc.php' */);

//  did you choose the correct routing from the options above??? Than do it!!!
//  dont foget to connect the right database in PDO file!!!

//  Function for handling errors:
function my_error_handler($e_number = null, $e_message = null, $e_file = null, $e_line = null, $e_vars = null)
{
    global $live, $contact_email;

    //  Build the error message:
    $message = "An error occurred in script '$e_file' on line 
        $e_line:\n$e_message\n";

    //  Add the backtrace:
    $message .= "<pre>" . print_r(debug_backtrace(), 1) . "</pre>\n";

    if (!$live) { //  Show the error in the browser.
    echo '<div class="error">' . nl2br($message) . '</div>';
    } else {  //  Development (print the error).
    //  Send the error in an email:
    error_log($message, 1, $contact_email, 'From: cordelfenevall@gmail.com');
    //  Only print an error message in the browser, if the error isn't a notice:
    if ($e_number != E_NOTICE) {
        echo '<div class="error">A system error occurred.
            We apologize for the inconvenience.</div>';
    }
    } //  End of $live IF-ELSE.

    return true; // So that PHP doesn't try to handle the error, too.
} //  End of my_error_handler() definition.

//  Use my error handler:
set_error_handler('my_error_handler');

//  Omit the closing PHP tag to avoid 'headers already sent' errors!

/*
    Every PHP script in this site uses
view files—separate HTML pages—to display content. Technically, a separate
view file should be created for displaying errors, too. Without such a file, you
may see errors displayed in odd places. I’ve omitted a dedicated error view file
here so as not to complicate things even further, but you can find it among the
downloadable code available at www.DMCInsights.com/ecom/.
    */
