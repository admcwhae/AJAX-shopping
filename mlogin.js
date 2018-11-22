    /*
        Logs in the manager
        Author: Alex McWhae 
        Date: 15/10/2018
    */
function mlogin()
{
    // get data from form
    var managerId = document.getElementById("managerId").value;
    var password = document.getElementById("password").value;

    // set variable to see if form is valid to false
    var validForm = true;
    var errMsg = "";

    // check that fields are not empty
    if (managerId == "" || managerId == null)
    {
        errMsg = "Please enter a manager ID.";
        validForm = false;
    }
    if (validForm && (password == "" || password == null))
    {
        errMsg = "Please enter password.";
        validForm = false;
    }
    // if fields filled in
    if (validForm) {
        var xhr = new XMLHttpRequest();
        var url = 'mlogin.php';
        // data to send in post request
        var formData = 'managerId=' + managerId + "&password=" + password;
        xhr.open('POST', url, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                // gets response text
                response = xhr.responseText;
                // if 200 OK response
                if (xhr.status == 200) {
                    // move to the buying.htm page
                    string = "<p>Hello " + response + ", please click one of the links below. <p>";
                    string += "<p><a href=\"listing.htm\">Listing</a></p>";
                    string += "<p><a href=\"processing.htm\">Processing</a></p>";
                    document.getElementById("container").innerHTML = string;
                }
                // if any other HTTP response
                else {
                    // display the error text
                    document.getElementById("loginError").innerHTML = response;
                }
            }
        }
        // sets header to send post data
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("Content-length", formData.length);
        xhr.setRequestHeader("Connection", "close");

        xhr.send(formData);
    }
    else {
        // displays error message if form invalid
        document.getElementById("loginError").innerHTML = errMsg;
    }
}

