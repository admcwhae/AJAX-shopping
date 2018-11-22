function login()
{
    // get data from form
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

    // set variable to see if form is valid to false
    var validForm = true;
    var errMsg = "";

    // check that fields are not empty
    if (email == "" || email == null)
    {
        errMsg = "Please enter an email address.";
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
        var url = 'login.php';
        // data to send in post request
        var formData = 'email=' + email + "&password=" + password;
        xhr.open('POST', url, true);


        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                // gets response text
                response = xhr.responseText;
                // if 200 OK response
                if (xhr.status == 200) {
                    // move to the buying.htm page
                    window.location.replace("buying.htm");
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

