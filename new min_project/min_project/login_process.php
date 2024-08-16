<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

$error_message = "";

// Hard-coded super admin credentials
$super_admin_nic = "111122223333";
$super_admin_password = "Admin@1234";
$hashed_super_admin_password = password_hash($super_admin_password, PASSWORD_DEFAULT); // Hash the password

// Hard-coded user_qr credentials
$user_qr_nic = "333344445555";
$user_qr_password = "Admin@2345";
$hashed_user_qr_password = password_hash($user_qr_password, PASSWORD_DEFAULT); // Hash the password

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the NIC is in the user_temp table
    $temp_sql = "SELECT * FROM user_temp WHERE nic='$nic'";
    $temp_result = mysqli_query($conn, $temp_sql);

    if (mysqli_num_rows($temp_result) > 0) {
        // NIC exists in user_temp, show message
        $error_message = "Super admin has not approved your request yet.";
    } elseif ($nic === $super_admin_nic) {
        // Verify the hard-coded super admin password
        if (password_verify($password, $hashed_super_admin_password)) {
            // Password is correct, start the session for super admin
            $_SESSION['username'] = 'superadmin';
            $_SESSION['first_name'] = 'Super';
            $_SESSION['last_name'] = 'Admin';
            $_SESSION['nic'] = $nic;

            // Redirect to the super admin dashboard
            header("Location: supper_admin/supper_admin.html");
            exit();
        } else {
            // If password does not match, set error message
            $error_message = "Invalid password. Please check again.";
        }
    } elseif ($nic === $user_qr_nic) {
        // Verify the hard-coded user_qr password
        if (password_verify($password, $hashed_user_qr_password)) {
            // Password is correct, start the session for user_qr
            $_SESSION['username'] = 'userqr';
            $_SESSION['first_name'] = 'User';
            $_SESSION['last_name'] = 'QR';
            $_SESSION['nic'] = $nic;

            // Redirect to the user_qr page
            header("Location: user_qr/user_qr.html");
            exit();
        } else {
            // If password does not match, set error message
            $error_message = "Invalid password. Please check again.";
        }
    } else {
        // Query to get the user data
        $sql = "SELECT * FROM user WHERE nic='$nic'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, start the session
                $_SESSION['username'] = $row['username'];
                $_SESSION['first_name'] = $row['first_name'];
                $_SESSION['last_name'] = $row['last_name'];
                $_SESSION['nic'] = $nic;

                // Redirect to the dashboard
                header("Location: welcome.html");
                exit();
            } else {
                // If password does not match, set error message
                $error_message = "Invalid password. Please check again.";
            }
        } else {
            // If NIC does not exist, set error message
            $error_message = "Invalid NIC. Please check again.";
        }
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>

        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>

            <div class="form-inner">
                <!-- Login Form -->
                <form action="login_process.php" method="post" class="login">
                    <div class="field">
                        <input type="text" name="nic" placeholder="NIC" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" id="loginPassword" required>
                    </div>
                    <br>
                    <div class="show-password-label">
                        <label class="show-password-label">
                            <input type="checkbox" onclick="togglePasswordVisibility('loginPassword')"> Show Password
                        </label>
                    </div>

                    <br>
                    <div class="pass-link">
                        <a href="#">Forgot password?</a>
                    </div>
                    <br>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="login" value="Login">
                    </div>
                    <div class="signup-link">
                        Create an account <a href="#">Signup now</a>
                    </div>
                    <div class="logos">
                        <img src="gover.jpg" alt="Logo 1">
                        <img src="log.jpg" alt="Logo 2">
                    </div>
                </form>


                <!-- Signup Form -->
                <form action="signup_process.php" method="post" class="signup" id="signupForm">
                    <div class="field-group">
                        <div class="field">
                            <input type="text" name="firstname" placeholder="First Name" required>
                        </div>
                        <div class="field">
                            <input type="text" name="lastname" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="field">
                        <input type="text" name="nic" placeholder="NIC" required>
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" id="signupPassword" required>
                        <small>Password must be at least 8 characters and include letters, numbers, and special characters.</small>
                    </div>
                    <br>
                    <br>
                    <div class="field">
                        <input type="password" name="confirm_password" placeholder="Confirm password" id="confirmPassword" required>
                    </div>
                    <br>

                    <div class="show-password-label">
                        <label class="show-password-label">
                            <input type="checkbox" onclick="togglePasswordVisibility('signupPassword', 'confirmPassword')"> Show Password
                        </label>
                    </div>
                    <bt>

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" name="signup" value="Signup">
                    </div>
                    <div class="logos">
                        <img src="gover.jpg" alt="Logo 1">
                        <img src="log.jpg" alt="Logo 2">
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="login.js"></script>
    <script src="signup.js"></script>
    <script>
        // Function to toggle password visibility
        function togglePasswordVisibility(...fields) {
            fields.forEach(function(fieldId) {
                var passwordField = document.getElementById(fieldId);
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                } else {
                    passwordField.type = "password";
                }
            });
        }
    </script>
</body>

</html>
