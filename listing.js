/*
    Handles all the client side scripting for the listing.htm page

    Author: Alex McWhae 
    Date: 15/10/2018
*/

function listItem()
{
    var name = document.getElementById("name").value;
    var price = document.getElementById("price").value;
    var qty = document.getElementById("qty").value;
    var description = document.getElementById("description").value;

    var errMsg = "";

    if (name == "" || name == null || price == "" || price == null || qty == "" || qty == null || description == "" || description == null)
    {
        errMsg = "Please fill in all required fields.";
    }
    if (errMsg == "") {
        var xhr = new XMLHttpRequest();
        var url = 'listing.php';
        var formData = 'name=' + name + "&price=" + price + '&qty=' + qty + "&description=" + description;

        xhr.open('POST', url, true);

        xhr.onreadystatechange = function() {//Call a function when the state changes.
            if(xhr.readyState == 4 && xhr.status == 200) {
                // displays the confirmation
                document.getElementById("container").innerHTML = xhr.responseText;
                document.getElementById("container").innerHTML += "<p><a href=\"listing.htm\">Add another item.</a></p>";
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(formData);   
    }
    else {
        document.getElementById("error").innerHTML = errMsg;
    }
}

