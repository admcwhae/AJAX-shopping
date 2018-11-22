<?php
    /*
        Removes the selected item from the cart

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    session_start();
    header('Content-Type: text/plain');

    $basket = $_SESSION["basket"];

    $filePath = "../../data/goods.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    $removeItemNumber = $_GET["itemNumber"];
    echo $removeItemNumber;
    $xmlDoc->load($filePath);
    $items = $xmlDoc->getElementsByTagName("item"); 

    // loops through each item
    foreach($items as $node) 
    { 
        $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;
        // if item number to remove and item number match
        if ($removeItemNumber == $itemNumber) {
            $qtyHold = $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
            $qty = $node->getElementsByTagName("qty")->item(0)->nodeValue;

            $qtyCart = $basket[$itemNumber]["qty"];

            // lowers the quantity on hold by the amount in the cart
            $node->getElementsByTagName("holdQty")->item(0)->nodeValue = $qtyHold - $qtyCart;
            // increases the quantity by the amount in the cart
            $node->getElementsByTagName("qty")->item(0)->nodeValue = $qty + $qtyCart;

            // clears the basket for that itemNumber
            unset($basket[$itemNumber]);
            // create a session from the basket
            $_SESSION["basket"] = $basket;

            $xmlDoc->save($filePath);
            // returns nothing, converting to html handled in buyingGetBasket.php
            // can break out of loop since item is removed
            break;
        }
    }
?>