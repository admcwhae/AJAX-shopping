<?php
    /*
        Server side script to log in the manager

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');
    // file path of manager.txt document
    $filePath = '../../data/manager.txt';

    // gets the txt file contents
    $textFile = file_get_contents($filePath);

    // generates an array of lines from file seperating by \n character
    $lines = explode('\n' ,$textFile);
    // gets entered id and password
    $managerId = $_POST["managerId"];
    $password = $_POST["password"];

    $errMsg = "";

    $managerFound = false;
    // loops through each line in txt file
    foreach ($lines as $line => $data) {
        // explodes line by ,
        $lineData = explode(',', $data); 
        // gets id on the line and trims white space from it
        $fileManagerId = trim($lineData[0]);
        // compares given id to this lines id
        if (strcmp($fileManagerId, $managerId) == 0) {
            // if match manager is found and gets the password for this line
            $managerFound = true;
            $filePassword = trim($lineData[1]);
            // breaks out of the loop since the manager is found
            break;
        }
    }
    if ($managerFound) {
        // compares passwords
        if (strcmp($password, $filePassword) == 0) {
            // passwords match no error to be generated therefore can login
        }
        else {
            // passwords dont match
            $errMsg = "Password does not match.";
        }
    }
    else {
        $errMsg = "That manager account could not be found";
    }

    if ($errMsg == "") {
        // No errors, therefore can login
        session_start();
        // creates session
        $_SESSION["managerId"] = $managerId;
        echo $managerId;
    }
    else {
        // Error somewhere, set code to 400: bad request and echo the error message
        http_response_code (400);
        echo $errMsg;
    }
?>