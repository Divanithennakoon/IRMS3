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

// Fetch user details based on NIC
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nic'])) {
    $nic = $_POST['nic'];
    $sql = "SELECT * FROM user_temp WHERE nic='$nic'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Check if user exists
    if ($user) {
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
        $password = $user['password']; // Assuming password is already hashed
        $username = strtolower($firstName . " " . $lastName);
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height to center vertically */
        }

        form {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            width: 400px;
        }

        .field {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .btn input[type="submit"] {
            background-color: #005246;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn input[type="submit"]:hover {
            background-color: #003d36;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="submit_user.php" method="post">
            <input type="hidden" name="nic" value="<?php echo $nic; ?>">
            <div class="field">
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo $firstName; ?>" readonly>
            </div>
            <div class="field">
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $lastName; ?>" readonly>
            </div>
            <div class="field">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo $username; ?>" readonly>
            </div>
            <div class="field">
                <label>Password:</label>
                <input type="password" name="password" value="<?php echo $password; ?>" readonly>
            </div>
            <div class="field">
                <label>File Tracking System:</label>
                <select name="file_tracking_system">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="not_access">Not Access</option>
                </select>
            </div>
            <div class="field">
                <label>Library Management System:</label>
                <select name="library_management_system">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="not_access">Not Access</option>
                </select>
            </div>
            <div class="field">
                <label>Inventory System:</label>
                <select name="inventory_system">
                    <option value="admin">Admin</option>
                    <option value="not_access">Not Access</option>
                </select>
            </div>
            <div class="field btn">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
