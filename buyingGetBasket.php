<?php
    /*
        Gets all the items in the basket, returning them in a html table 

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    session_start();
    // if session basket session is set and not empty
    if (isset($_SESSION["basket"]) && (count($_SESSION["basket"]) > 0)) {

        $basket = $_SESSION["basket"];
        $tableString = "<table><thead><td>Item Number</td><td>Name</td><td>Price</td><td>Quantity</td><td>Remove</td></thead>";
        $totalPrice = 0;
        // loop through each item in the basket
        foreach($basket as $item => $itemNumber) {
            $rowString = "<tr>";
            $rowString .= "<td>$item</td>";
            // loop through every value in the item
            foreach($itemNumber as $key => $values) {
                // if price add the $ to the table
                if ($key == "price") 
                    $rowString .= "<td>$$values</td>";
                else
                    $rowString .= "<td>$values</td>";
            }
            // calculate total price
            $totalPrice += $itemNumber["price"] * $itemNumber["qty"];
            // add the remove button
            $rowString .= "<td><input type='button' onclick='removeItem($item)' value='Remove'/></td>";
            $rowString .= "</tr>";
            $tableString .=  $rowString;
        }

        $rowString = "<tr><td></td><td>Total Price</td><td>$$totalPrice</td></tr>";
        $tableString .=  $rowString;
        $tableString .= "</table>";

        $returnString = $tableString;
        // add cancel and confirm order buttons
        $returnString.= "<p><input type='button' onclick='confirmOrder()' value='Confirm Order'/>";
        $returnString.= "<input type='button' onclick='cancelOrder()' value='Cancel Order'/></p>";

        echo $returnString;
    }
    else 
        echo "Shopping cart is empty, add items from the catalogue above to start.";

?>