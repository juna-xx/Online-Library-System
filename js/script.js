// LOGIN VALIDATION PLACEHOLDER
function validateLogin() {
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;

    if (!email || !password) {
        document.getElementById("loginMsg").innerText =
            "Please fill in both fields.";
        return false;
    }

    document.getElementById("loginMsg").innerText =
        "Checking login credentials...";
    return true; // submission continues
}

// REGISTER VALIDATION PLACEHOLDER
function validateRegister() {
    let pass = document.getElementById("password").value;
    let confirm = document.getElementById("confirmPassword").value;

    if (pass !== confirm) {
        document.getElementById("registerMsg").innerText =
            "Passwords do not match!";
        return false;
    }

    document.getElementById("registerMsg").innerText =
        "Creating account...";
    return true;
}
