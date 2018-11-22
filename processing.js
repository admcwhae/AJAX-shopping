/*
    Handles the client side scripting for the processing.htm page

    Author: Alex McWhae
    Date: 15/10/2018
*/

// displays the table on the processing page
function getTable() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "processingGetTable.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            // get the returned text
            document.getElementById("processTable").innerHTML = xhr.responseText;
        }
    }
    xhr.send(null);  
}

// processes the sold orders 
function process() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "processingProcess.php", true);
    xhr.onreadystatechange =  function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            // get the returned text
            alert(xhr.responseText);
            getTable();
            
        }
    }
    xhr.send(null);  
}


// function to call on page load
function init() {
    getTable();
    // refreshes the table every 10 seconds
    setInterval(getTable, 10000);
}