function logout()
{

    var xhr = new XMLHttpRequest();
    var url = 'logout.php';
    xhr.open('GET', url, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            // gets response text
            response = xhr.responseText;
            // if 200 OK response
            if (xhr.status == 200) {
                // display message
                document.getElementById("message").innerHTML = response;
            }
        }
    }
    // sets header to send post data
    xhr.send();
}

    


