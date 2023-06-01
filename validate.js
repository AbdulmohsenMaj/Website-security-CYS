function validateForm() {
    var email = document.getElementById("email");
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

 

    if (email) {
        // Check if the email is empty or not
        email = email.value;
        if (email == "" || username == "" || password == "") {
            alert("Email, username, and password must be filled out");
            window.history.replaceState(null, null, "index.php?error=2");//add error code to url to display error message
            return false;
        }

        // Add regex to check for valid email
        if (!email.includes("@")) {
            alert("Email must be valid");
            return false;
        }

        // add sanitization checks
        if (email.includes("<") || email.includes(">") || email.includes("'") || email.includes("\"")) {
            alert("Email must be valid");
            return false;
        }

        // Check if the email is valid
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Email must be a valid email address");
            return false;
        }
    } else {
        if (username == "" || password == "") {
            alert("Username and password must be filled out");
            return false;
        }
    }

    // Add regex to check for valid username
    if (username.length < 6) {
        alert("Username must be at least 6 characters");
        return false;
    }
    // Add regex to check for valid password
    if (password.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    
    // add sanitization checks
    if (username.includes("<") || username.includes(">") || username.includes("'") || username.includes("\"")) {
        alert("Username must be valid");
        return false;
    }
    if (password.includes("<") || password.includes(">") || password.includes("'") || password.includes("\"")) {
        alert("Password must be valid");
        return false;
    }
    var regex = /[<>'"=\\;:{}()\[\] ]/g;
    if (regex.test(username) || regex.test(password)) {
        alert("Username and password must not contain any of the following characters: <, >, ', \", =, \\, ;, :, {, }, (, ), [, ], and space");
        return false;
    }

    return true;
}
