<?php
    /*
        Gets the catalogue

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');

    $filePath = "../../data/goods.xml";
    // checks if the goods.xml document exists
    if (!file_exists($filePath)) {
        echo "There are no items to display at this time.";
    }
    else {
        $xmlDoc = new DomDocument();
        $xmlDoc->preserveWhiteSpace = false;
        $xmlDoc->formatOutput = true;
        $xmlDoc->load($filePath);

        $items = $xmlDoc->getElementsByTagName("item"); 
        // checks that there are some items to display, if none
        if ($items->length==0) {
            echo "There are no items to display at this time.";
        }
        else {
            // create the table head row
            $tableString = "<table><thead><td>Item Number</td><td>Name</td><td>Description</td><td>Price</td><td>Quantity</td><td>Add</td></thead>";
            // loops through each item
            foreach($items as $node) 
            { 
                // gets the quantity
                $qty =  $node->getElementsByTagName("qty")->item(0)->nodeValue;
                // enters the row if the quantity is greater than 0
                if ($qty > 0) {
                    $rowString = "<tr>";
    
                    $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;
                    $rowString .= "<td>$itemNumber</td>";
    
                    $itemName =  $node->getElementsByTagName("name")->item(0)->nodeValue;
                    $rowString .= "<td>$itemName</td>";           
    
                    $itemDescription =  $node->getElementsByTagName("description")->item(0)->nodeValue;
                    // shortens the description if it is longer than 20 characters and adds ... to the end of it
                    if (strlen($itemDescription) > 20) {
                        $itemDescription = substr($itemDescription, 0, 20)."...";
                    }
                    $rowString .= "<td>$itemDescription</td>";                     
            
                    $price =  $node->getElementsByTagName("price")->item(0)->nodeValue;
                    $rowString .= "<td>$$price</td>";
    
                    $rowString .= "<td>$qty</td>";
    
                    // adds the add item button
                    $rowString .= "<td><input type='button' onclick='addItem($itemNumber)' value='Add'/></td>";
                    
                    $rowString .= "</tr>";
    
                    $tableString .= $rowString;
                }
            }
            $tableString .= "</table>";
            echo $tableString;
        }
    }
?>