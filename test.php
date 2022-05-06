<?php
    /*
     * Enable error reporting
     */
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    date_default_timezone_set('UTC');
 
    /*
     * Setup email addresses and change it to your own
     */
    $from = "creosoulscomp5@gmail.com";
    $to = "swapna.jiwtode@emmersivetech.com";
    $subject = "Simple test for mail function";
    $message = "This is a test to check if php mail function sends out the email";
    $headers = "From:" . $from;
 
    /*
     * Test php mail function to see if it returns "true" or "false"
     * Remember that if mail returns true does not guarantee
     * that you will also receive the email
     */
    if(mail($to,$subject,$message, $headers))
    {
        echo "Test email sendd.";
        echo $this->email->print_debugger();
    } 
    else 
    {
        echo "Failed to send.";
    }
?>
