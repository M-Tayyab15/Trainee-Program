<?php 
/* 
 * PayPal and database configuration 
 */ 

// PayPal configuration 
define('PAYPAL_ID', 'sb-uxow334089573@business.example.com');  // PayPal sandbox business email
define('PAYPAL_SANDBOX', TRUE); // TRUE for sandbox environment, FALSE for live environment

define('PAYPAL_RETURN_URL', 'http://www.example.com/success.php');  // URL to redirect after payment
define('PAYPAL_CANCEL_URL', 'http://www.example.com/cancel.php');  // URL to redirect if the user cancels payment
define('PAYPAL_NOTIFY_URL', 'http://www.example.com/ipn.php');  // URL for Instant Payment Notification (IPN) handling
define('PAYPAL_CURRENCY', 'USD');  // The currency code to use

// Database configuration (using your details)
define('DB_HOST', 'localhost');  // MySQL Database Host
define('DB_USERNAME', 'root');  // MySQL Database Username
define('DB_PASSWORD', '');  // MySQL Database Password (empty in your case)
define('DB_NAME', 'db_users');  // MySQL Database Name

// Create MySQL connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Change not required
define('PAYPAL_URL', (PAYPAL_SANDBOX == true) ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr"); 
?>
