/*
    Client-side script to register a new customer

    Author: Alex McWhae 
    Date: 15/10/2018
*/

// checks the email to see if it is already in use
function checkEmail() {
    email = document.getElementById("email").value;
    
    if (email == null || email == "") {
        document.getElementById("emailError").innerHTML = "Please enter an email address.";
        return false;
    }
    else {
        var xhr = new XMLHttpRequest();
        var url = 'registerCheckEmail.php';
        var formData = 'email=' + email;
        xhr.open('POST', url, false);
    
        xhr.onreadystatechange = function() {//Call a function when the state changes.
            if(xhr.readyState == 4) {
                if (xhr.status == 200) {
                    document.getElementById("emailError").innerHTML = "";
                    return true;
                }
                else {
                    document.getElementById("emailError").innerHTML = xhr.responseText;
                    return false;
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(formData);  
    }
}

function validateForm()
{
    var email = document.getElementById("email").value;

    var firstName = document.getElementById("firstName").value;
    var lastName = document.getElementById("lastName").value;
    var password = document.getElementById("password").value;
    var passwordCheck = document.getElementById("passwordCheck").value;
    var phone = document.getElementById("phone").value;

    var validForm = true;
    var errMsg = "";

    if (firstName == "" || firstName == null || lastName == "" || lastName == null || password == "" || password == null || email == "" || email == null)
    {
        errMsg = "Please fill in all required fields.";
        validForm = false;
    }
    if (password != passwordCheck && validForm)
    {
        errMsg = "Password fields must match.";
        validForm = false;
    }

    var pattern = /^(\(0\d\)|0\d )\d{8}$/;
    if (validForm && phone != "" && phone != null && !pattern.test(phone)) 
    {
        errMsg = "Please put phone number in form of 0X XXXXXXXX or (0X)XXXXXXXX.";
        validForm = false;
    }
  
    if (validForm) {
        var xhr = new XMLHttpRequest();
        var url = 'register.php';
        var formData = 'firstName=' + firstName + "&lastName=" + lastName + '&email=' + email + "&password=" + password + "&phone=" + phone;

        xhr.open('POST', url, true);

        xhr.onreadystatechange = function() {//Call a function when the state changes.
            if(xhr.readyState == 4) {
                if (xhr.status == 200) {
                var resultHTML = '<p> Account successfully created, <br/>Email Address: ' + email + '<br/>Name: ' + firstName + ' ' + lastName;
                resultHTML += '<form action="buyonline.htm"><input type="submit" value="Home"/></form>';
                
                // displays the confirmation
                document.getElementById("container").innerHTML = resultHTML;
                }
                else {
                    alert(xhr.responseText);
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(formData);   
    }
    else {
            alert(errMsg);
    }
}

