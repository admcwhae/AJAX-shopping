<?php 
    /*
        Server side script for registering new customer

        Author: Alex McWhae 
        Date: 15/10/2018
    */

    header('Content-Type: text/plain');

    $email = $_POST["email"];
    
    $filePath = "../../data/customers.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    if (!file_exists($filePath)) {
        // no steps necessary email is ok.
    }
    else {
        $xmlDoc->load($filePath);

        $customers = $xmlDoc->getElementsByTagName('customer');
        // for every customer
        foreach($customers as $node) 
        {   
            // get the email from xml
            $xmlEmail =  $node->getElementsByTagName("email")->item(0)->nodeValue;

            // if the email matches
            if (strcmp($xmlEmail, $email) == 0) {
                // set error code
                http_response_code(400);
                echo "That email is already associated with an account.";
                // break from the loop
                break;
            }
        }   
    }
?>





