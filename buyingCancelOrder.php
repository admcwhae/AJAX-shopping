<?php
    /*
        Cancels all the orders in the shopping cart

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');
    session_start();

    $basket = $_SESSION["basket"];

    $filePath = "../../data/goods.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    $xmlDoc->load($filePath);
    $items = $xmlDoc->getElementsByTagName("item");

    // loops through each line in the basket
    foreach($basket as $lineItemNumber => $linevalues) {
        // for each item in the xml document
        foreach($items as $node) 
        { 
            $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;
            // if item number to remove and item number match
            if ($itemNumber == $lineItemNumber) {

                $qtyHold = $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
                $qty = $node->getElementsByTagName("qty")->item(0)->nodeValue;            

                $qtyCart = $basket[$lineItemNumber]["qty"];

                // decrease qty hold by amount in the cart
                $node->getElementsByTagName("holdQty")->item(0)->nodeValue = $qtyHold - $qtyCart;
                // decrease qty by amount in cart
                $node->getElementsByTagName("qty")->item(0)->nodeValue = $qty + $qtyCart;
            }
        }
    }
        
    $xmlDoc->save($filePath);
    unset($_SESSION["basket"]);
    echo "Your purchase request has been cancelled, welcome to shop next time.";
?>