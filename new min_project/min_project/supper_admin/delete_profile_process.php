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

    // Query to get user data
    $stmt = $conn->prepare("SELECT * FROM user WHERE nic = ?");
    $stmt->bind_param("s", $nic);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $error_message = "No user found with this NIC.";
    }

    $stmt->close();
} else {
    header("Location: delete_profile.html");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .user-details {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            margin-top: 80px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        .details {
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #ff0000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="user-details">
        <?php if (isset($user)): ?>
            <h2>User Details</h2>
            <div class="details">
                <label>First Name:</label>
                <p><?php echo htmlspecialchars($user['first_name']); ?></p>
                <label>Last Name:</label>
                <p><?php echo htmlspecialchars($user['last_name']); ?></p>
                <label>Username:</label>
                <p><?php echo htmlspecialchars($user['username']); ?></p>
                <label>NIC:</label>
                <p><?php echo htmlspecialchars($user['nic']); ?></p>
            </div>
            <form action="delete_user.php" method="POST">
                <input type="hidden" name="nic" value="<?php echo htmlspecialchars($user['nic']); ?>">
                <button type="submit">Delete User</button>
            </form>
        <?php else: ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <a href="delete_profile.html">Go Back</a>
        <?php endif; ?>
    </div>
</body>
</html>
