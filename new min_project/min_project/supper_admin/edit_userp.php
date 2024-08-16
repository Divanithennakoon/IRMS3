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
$dbname = "min_project";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .content1 {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 10px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            margin-top: 80px;
        }
        .left-content1 {
            margin: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            color: red;
        }
    </style>
</head>
<body>
    <div class="content1">
        <div class="left-content1">
            <h2>Edit User</h2>
            <form action="edit_user.php" method="POST">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                <label for="nic">NIC:</label>
                <input type="text" id="nic" name="nic" value="<?php echo $user['nic']; ?>" readonly>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required>
                <button type="submit" name="update">Update Details</button>
            </form>
        </div>
    </div>
</body>
</html>
