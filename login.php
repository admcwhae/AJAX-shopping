<?php
    header('Content-Type: text/plain');
    // file path of xml document
    $filePath = '../../data/customers.xml';

    $errMsg = "";
    // checks if file exists
    if (!file_exists($filePath)) {
        $errMsg = "No customers signed up for system.";
    }
    else {
        $xmlDoc = new DomDocument();
        $xmlDoc->load($filePath);

        $email = $_POST["email"];
        $password = $_POST["password"];

        $emailFound = false;
        // gets the customer elements from the xml doc
        $customer = $xmlDoc->getElementsByTagName("customer"); 
        // loops through each customer
        foreach($customer as $node) 
        { 
            // gets the value of the email for the customer
            $emailNode =  $node->getElementsByTagName("email")->item(0)->nodeValue;
            // compares entered email to email from xml document
            if (strcmp($emailNode,$email) == 0)
            {
                // if match, get password and id and set emailfound to true
                $emailFound = true;
                $passwordNode = $node -> getElementsByTagName("password")->item(0)->nodeValue;
                $idNode = $node -> getElementsByTagName("id")->item(0)->nodeValue;
                // no point looping through entire loop, hence break out of loop
                break;
            }
        }
        if ($emailFound) {
            // email found match passwords
            if (strcmp($passwordNode,$password) == 0) {
                // passwords match no steps need to be taken
            }
            else {
                // passwords do not match
                $errMsg = "Password entered incorrectly.";
            }
        }
        else {
            // no matching email address
            $errMsg = "There is no account for that email address.";
        }
    }

    if ($errMsg == "") {
        // No errors, therefore can login
        session_start();
        $_SESSION["customerId"] = $idNode;
        echo "$idNode";
    }
    else {
        // Error somewhere, set code to 400: bad request and echo the error message
        http_response_code (400);
        echo $errMsg;
    }
?>