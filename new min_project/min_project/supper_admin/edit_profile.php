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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetch'])) {
    $nic = $_POST['nic'];

    // Fetch user details from the database
    $stmt = $conn->prepare("SELECT * FROM user WHERE nic = ?");
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['edit_user'] = $user;
        header("Location: edit_user1.php");
        exit();
    } else {
        echo "No user found with the provided NIC.";
    }

    $stmt->close();
}

$conn->close();
?>
