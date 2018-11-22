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
            $tableString = "<table><thead><tr><td>Item Number</td><td>Name</td><td>Price</td><td>Quantity Available</td><td>Quantity on Hold</td><td>Quantity Sold</td></tr></thead>";
            // loops through each item
            foreach($items as $node) 
            {              
                $rowString = "<tr>";
                // number
                $itemNumber =  $node->getElementsByTagName("number")->item(0)->nodeValue;
                $rowString .= "<td>$itemNumber</td>";
                // name
                $itemName =  $node->getElementsByTagName("name")->item(0)->nodeValue;
                $rowString .= "<td>$itemName</td>";                        
                // price
                $price =  $node->getElementsByTagName("price")->item(0)->nodeValue;
                $rowString .= "<td>$$price</td>";
                // qty
                $qty =  $node->getElementsByTagName("qty")->item(0)->nodeValue;
                $rowString .= "<td>$qty</td>";
                // holdQty
                $holdQty =  $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
                $rowString .= "<td>$holdQty</td>";
                // soldQty
                $soldQty =  $node->getElementsByTagName("soldQty")->item(0)->nodeValue;
                $rowString .= "<td>$soldQty</td>";
                // finish row and append to table string
                $rowString .= "</tr>";
                $tableString .= $rowString;
            }
            $tableString .= "</table>";
            // adds the processing button at the bottom of the table
            $processButton = "<p><input type='button' onclick='process();' value='Process'/><p/>";
            // returns html strings
            echo $tableString.$processButton;
        }
    }
?>