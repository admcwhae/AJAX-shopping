<?php
    /*
        Adds an item to the cart

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');
    session_start();
    if (!isset($_SESSION["basket"])) {
        $_SESSION["basket"] = "";
    }

    $basket = $_SESSION["basket"];

    $filePath = "../../data/goods.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    $addItemNumber = $_GET["itemNumber"];

    $xmlDoc->load($filePath);

    $items = $xmlDoc->getElementsByTagName("item"); 

        
    // loops through each item
    foreach($items as $node) 
    { 
        $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;

        // if item number to add and item number match
        if (strcmp($addItemNumber, $itemNumber) == 0) {
            
            $qty = $node->getElementsByTagName("qty")->item(0)->nodeValue;
            if ($qty > 0) {

                $basket[$itemNumber]["name"] = $node->getElementsByTagName("name")->item(0)->nodeValue;
                $basket[$itemNumber]["price"] = $node->getElementsByTagName("price")->item(0)->nodeValue;
                if (isset($basket[$itemNumber]["qty"]))
                    $basket[$itemNumber]["qty"] += 1;   
                else 
                    $basket[$itemNumber]["qty"] = 1;

                // create a session from the basket
                $_SESSION["basket"] = $basket;

                // decrement qty in xml doc and increment qty on hold
                $node->getElementsByTagName("qty")->item(0)->nodeValue = $qty - 1;
                $qtyHold = $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
                $node->getElementsByTagName("holdQty")->item(0)->nodeValue = $qtyHold + 1;

                $xmlDoc->save($filePath);

                // returns nothing, converting to html handled in buyingGetBasket.php
            }
            else {
                // if not available, qty = 0, return 400 http response and message saying item is not available
                http_response_code (400);
                echo "Sorry that item is not available.";
            }
            // break out of the for loop
            break;
        }
    }
?>