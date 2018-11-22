<?php 
    /*
        Server side script for registering new customer

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');

    $email = $_POST["email"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    

    header('Content-Type: text/plain');

    $email = $_POST["email"];
    
    $filePath = "../../data/customers.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    $emailValid = true;

    // check if email is valid
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
                $emailValid = false;
                // break from the loop
                break;
            }
        }   
    }

    if ($emailValid) {
        $phoneSet = false;
        if ($phone != "") {
            $phoneSet = true;
        }

        $filePath = "../../data/customers.xml";

        $xmlDoc = new DomDocument();
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->formatOutput = true;

        if (!file_exists($filePath)) {
            $customers = $xmlDoc->createElement('customers');
            $xmlDoc->appendChild($customers);
        }
        else {
            $xmlDoc->load($filePath);
        }

        // create a customer node
        $customers = $xmlDoc->getElementsByTagName('customers')->item(0);
        $customer = $xmlDoc->createElement('customer');
        $customers->appendChild($customer);
        
        // gets the number of customers to make the new id
        $count = $xmlDoc->getElementsByTagName('customer')->length;
        
        // create an id node
        $idNode = $xmlDoc->createElement('id');
        $customer->appendChild($idNode);
        $idValue = $xmlDoc->createTextNode($count);
        $idNode->appendChild($idValue);
    
        // create an email node
        $emailNode = $xmlDoc->createElement('email');
        $customer->appendChild($emailNode);
        $emailValue = $xmlDoc->createTextNode($email);
        $emailNode->appendChild($emailValue);
        
        // create an firstName node
        $firstNameNode = $xmlDoc->createElement('firstName');
        $customer->appendChild($firstNameNode);
        $firstNameValue = $xmlDoc->createTextNode($firstName);
        $firstNameNode->appendChild($firstNameValue);
        
        // create an lastName node
        $lastNameNode = $xmlDoc->createElement('lastName');
        $customer->appendChild($lastNameNode);
        $lastNameValue = $xmlDoc->createTextNode($lastName);
        $lastNameNode->appendChild($lastNameValue);
        
        //create a password node 
        $pwd = $xmlDoc->createElement('password');
        $customer->appendChild($pwd);
        $pwdValue = $xmlDoc->createTextNode($password);
        $pwd->appendChild($pwdValue);

        // if phone set append phone number
        if ($phoneSet) {
            $phoneNode = $xmlDoc->createElement('phone');
            $customer->appendChild($phoneNode);
            $phoneValue = $xmlDoc->createTextNode($phone);
            $phoneNode->appendChild($phoneValue);
        }

        // save the xml file
        $xmlDoc->save($filePath);
    }
?>




