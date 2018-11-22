<?php
    /*
        Confirms the order in the shopping cart

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
        
    $totalPrice = 0;
    // loops through each line in the basket
    foreach($basket as $lineItemNumber => $linevalues) {
        // for each item in the xml document
        foreach($items as $node) 
        { 
            // get the item number from the xml doc
            $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;
            // if item number to remove and item number match
            if ($itemNumber == $lineItemNumber) {
                // get numerous quantities
                $qtyHold = $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
                $qtySold = $node->getElementsByTagName("soldQty")->item(0)->nodeValue;
                $price = $node->getElementsByTagName("price")->item(0)->nodeValue;                

                $qtyCart = $basket[$lineItemNumber]["qty"];

                // calculate and add to the total price
                $totalPrice += $price * $qtyCart;

                // decrease qty hold by the amount in the cart
                $node->getElementsByTagName("holdQty")->item(0)->nodeValue = $qtyHold - $qtyCart;
                // increase qty sold by the amount in the cart
                $node->getElementsByTagName("soldQty")->item(0)->nodeValue = $qtySold + $qtyCart;
            }
        }
    }
    // save the xml doc
    $xmlDoc->save($filePath);
    // destroys the basket session
    unset($_SESSION["basket"]);
    // send message back to client
    echo "Your purchase has been confirmed and total amount due to pay is $$totalPrice.";
?>