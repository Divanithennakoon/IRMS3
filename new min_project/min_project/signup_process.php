<?php

$servername = "localhost";
$username = "root";
$dbPassword = "";
$dbname = "min_project";

$conn = mysqli_connect($servername, $username, $dbPassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $nic = $_POST['nic'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('Passwords do not match.'); });</script>";
        exit();
    }

    // Check if password length is more than 8 characters
    if (strlen($password) < 8) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('Password must be more than 8 characters.'); });</script>";
        exit();
    }

    // Improved NIC validation with regular expression
    $nicPattern = '/^(?:\d{9}[A-Z]$|\d{12})$/';
    // Allows 9 digits + 1 letter OR 12 digits
    if (!preg_match($nicPattern, $nic)) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('NIC must be either 9 digits followed by a letter (e.g., 123456789V) or 12 digits (e.g., 123456789012).'); });</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user details into the database
    $sql = "INSERT INTO user_temp (first_name, last_name, nic, password) VALUES ('$firstname', '$lastname', '$nic', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>document.addEventListener('DOMContentLoaded', function() { alert('New record created successfully.'); });</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

 