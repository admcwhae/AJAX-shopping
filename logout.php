<?php
    /*
        Logs out the user

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    session_start();

    if (isset($_SESSION["customerId"])) {
        echo "Thanks for shopping with us customer: ".$_SESSION["customerId"]. ".";
    }
    else if (isset($_SESSION["managerId"])) {
        echo "Thanks for managing, manager: ".$_SESSION["managerId"]. ".";
    }
    else {
        echo "No one was logged in...";
    }

    // destroys sessions
    session_destroy();
?>