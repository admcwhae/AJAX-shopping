/*
    Handles all the client side scripting for the buying.htm page

    Author: Alex McWhae 
    Date: 15/10/2018
*/

// gets the catalogue from xml file
function getCatalogue()
{
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingGetCatalogue.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            // get the returned text
            document.getElementById("catalogue").innerHTML = xhr.responseText;
        }
    }
    xhr.send(null);  
}

// gets the basket from
function getBasket() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingGetBasket.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            // get the returned text
            document.getElementById("basket").innerHTML = xhr.responseText;
        }
    }
    xhr.send(null);  
}

// add specified item number item to shopping basket
function addItem(itemNumber) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingAddItem.php?itemNumber="+itemNumber, true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4) {
            if (xhr.status == 200) {
                // if ok, get basket
                getBasket();
                getCatalogue();
            }
            else {
                // used if error in adding item to basket
                alert(xhr.responseText);
            }
        }
    }
    xhr.send(null); 
}

// remove the given item from the shopping basket
function removeItem(itemNumber) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingRemoveItem.php?itemNumber="+itemNumber, true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4) {
            if (xhr.status == 200) {
                // if ok, get basket
                getBasket();
                getCatalogue();
            }
        }
    }
    xhr.send(null); 
}

// confirms the order, moving everything to sold and billing the customer
function confirmOrder() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingConfirmOrder.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4) {
            if (xhr.status == 200) {
                // shows the purchase confirmation in the basket
                document.getElementById("basket").innerHTML = xhr.responseText;
            }
        }
    }
    xhr.send(null); 
}

// cancels the order
function cancelOrder() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingCancelOrder.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4) {
            if (xhr.status == 200) {
                // shows cancellation message in the basket div
                document.getElementById("basket").innerHTML = xhr.responseText;
                // update catalogue
                getCatalogue();
            }
        }
    }
    xhr.send(null); 
}

// cancels the order and logs the user out
function logout() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "buyingCancelOrder.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4) {
            if (xhr.status == 200) {
                // moves the window to logout
                window.location.replace("logout.htm");
            }
        }
    }
    xhr.send(null); 
}

// funciton to call on page load
function init() {
    // get catalogue and basket initially
    getCatalogue();
    getBasket();
    // refreshes catalogue every 10 seconds
    setInterval(getCatalogue, 10000);
}