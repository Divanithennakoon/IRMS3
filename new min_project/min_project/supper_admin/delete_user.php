<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nic'])) {
    $nic = $_POST['nic'];

    // Delete user from the database
    $stmt = $conn->prepare("DELETE FROM user WHERE nic = ?");
    $stmt->bind_param("s", $nic);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
        // Optionally, redirect to another page after deletion
        // header("Location: user_list.php");
        // exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
