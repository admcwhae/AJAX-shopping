<?php
   /*
        Process the orders

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');

    $filePath = "../../data/goods.xml";
    // checks if the goods.xml document exists

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;
    $xmlDoc->load($filePath);

    $items = $xmlDoc->getElementsByTagName("item"); 
    // create the table head row
    

    $i = 0;
    // loops through each item
    foreach($items as $node) 
    {   
        $qty =  $node->getElementsByTagName("qty")->item(0)->nodeValue;
        $holdQty =  $node->getElementsByTagName("holdQty")->item(0)->nodeValue;
        
        
        // set the sold quantity to 0
        $node->getElementsByTagName("soldQty")->item(0)->nodeValue = 0;
           
        $totalQty = $qty + $holdQty;

        // if no traces of item left, need to delete from goods.xml
        if ($totalQty == 0) {
            // need to delete the item from goods.xml
            $xmlDoc->documentElement->removeChild($node);
        }
    }   
    $xmlDoc->save($filePath);
    echo "Products processed."
?>