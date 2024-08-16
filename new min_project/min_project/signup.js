document.addEventListener("DOMContentLoaded", function() {
    const signupForm = document.getElementById("signupForm");

    signupForm.addEventListener("submit", function(event) {
        const password = document.getElementById("password").value;
        const confirmPassword = signupForm.querySelector('input[name="confirm_password"]').value;
        const nic = signupForm.querySelector('input[name="nic"]').value;

        let errorMessages = [];

        if (password.length < 8) {
            errorMessages.push("Password must be more than 8 characters.");
        }

        const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordPattern.test(password)) {
            errorMessages.push("Password must include letters, numbers, and special characters.");
        }

        if (password !== confirmPassword) {
            errorMessages.push("Passwords do not match.");
        }

        const nicPattern = /^(?:\d{9}[A-Z]$|\d{12})$/;
        if (!nicPattern.test(nic)) {
            errorMessages.push("NIC must be either 9 digits followed by a letter (e.g., 123456789V) or 12 digits (e.g., 123456789012).");
        }

        if (errorMessages.length > 0) {
            event.preventDefault();
            alert(errorMessages.join("\n"));
        }
    });
});
