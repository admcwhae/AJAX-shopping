<?php 
    /*
        Lists an item in goods.xml

        Author: Alex McWhae 
        Date: 15/10/2018
    */
    header('Content-Type: text/plain');

    $name = $_POST["name"];
    $price = $_POST["price"];
    $qty = $_POST["qty"];
    $description = $_POST["description"];

    $holdQty = 0;
    $soldQty = 0;

    $filePath = "../../data/goods.xml";

    $xmlDoc = new DomDocument();
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->formatOutput = true;

    // checks to see if file already exists
    if (!file_exists($filePath)) {
        // creates file
        $goods = $xmlDoc->createElement('goods');
        $xmlDoc->appendChild($goods);
        // create a item node
        $goods = $xmlDoc->getElementsByTagName('goods')->item(0);
        $item = $xmlDoc->createElement('item');
        // sets new number to 1
        $newNumber = 1;
    }
    else {
        $xmlDoc->load($filePath);
        // create a item node
        $goods = $xmlDoc->getElementsByTagName('goods')->item(0);
        $item = $xmlDoc->createElement('item');
        // gets the last item number in the file and adds 1 to it
        $newNumber = $goods->lastChild->getElementsByTagName('number')->item(0)->nodeValue + 1;
    }

    $goods->appendChild($item);
    
	// create a number node
	$numberNode = $xmlDoc->createElement('number');
	$item->appendChild($numberNode);
	$numberValue = $xmlDoc->createTextNode($newNumber);
	$numberNode->appendChild($numberValue);
  
	// create an name node
	$nameNode = $xmlDoc->createElement('name');
	$item->appendChild($nameNode);
	$nameValue = $xmlDoc->createTextNode($name);
	$nameNode->appendChild($nameValue);
	
	// create an price node
	$priceNode = $xmlDoc->createElement('price');
	$item->appendChild($priceNode);
	$priceValue = $xmlDoc->createTextNode($price);
    $priceNode->appendChild($priceValue);
    
    // creates a description node
    $descriptionNode = $xmlDoc->createElement('description');
	$item->appendChild($descriptionNode);
	$descriptionValue = $xmlDoc->createTextNode($description);
    $descriptionNode->appendChild($descriptionValue);

    // creates a qty node
    $qtyNode = $xmlDoc->createElement('qty');
	$item->appendChild($qtyNode);
	$qtyValue = $xmlDoc->createTextNode($qty);
    $qtyNode->appendChild($qtyValue);

    // creates a holdQty node
    $holdQtyNode = $xmlDoc->createElement('holdQty');
	$item->appendChild($holdQtyNode);
	$holdQtyValue = $xmlDoc->createTextNode($holdQty);
    $holdQtyNode->appendChild($holdQtyValue);

    // creates a soldQty node
    $soldQtyNode = $xmlDoc->createElement('soldQty');
	$item->appendChild($soldQtyNode);
	$soldQtyValue = $xmlDoc->createTextNode($soldQty);
    $soldQtyNode->appendChild($soldQtyValue);

    // save the xml file
    $xmlDoc->save($filePath);
    echo "The item has been listed in the system, and the item number is $newNumber.";
?>




