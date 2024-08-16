<?php
session_start();

// Check if the user details are set in the session
if (!isset($_SESSION['edit_user'])) {
    header("Location: edit_profile.html");
    exit();
}

$user = $_SESSION['edit_user'];

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//update detalis

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $nic = $_POST['nic'];
    $password = $_POST['password'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ?, username = ?, password = ? WHERE nic = ?");
    $stmt->bind_param("sssss", $first_name, $last_name, $username, $password, $nic);

    if ($stmt->execute()) {
        echo "User details updated successfully.";
    } else {
        echo "Error updating user details: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

